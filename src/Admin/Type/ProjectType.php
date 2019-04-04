<?php

namespace App\Admin\Type;

use App\Traits\LoggedUserTrait;
use App\Traits\Repository\ProjectRepositoryTrait;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Admin\Transformer\CollectionToArrayTransformer;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectType extends ChoiceType
{
    use LoggedUserTrait;
    use ProjectRepositoryTrait;

    protected function getProjects(): array
    {
        return $this->getProjectRepository()->getProjectArrayByOwner($this->getLoggedUser());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => $this->getProjects(),
            'choices_as_values' => true,
            'choice_translation_domain' => false
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->get
        // if (true === $options['multiple']) {
        //     $builder->get('forms')
        // }


        $builder->get('tags')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    // transform the array to a string
                    return implode(', ', $tagsAsArray);
                },
                function ($tagsAsString) {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString);
                }
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'project';
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
