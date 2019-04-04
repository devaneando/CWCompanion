<?php

namespace App\Admin\Type;

use App\Traits\LoggedUserTrait;
use App\Traits\Repository\ProjectRepositoryTrait;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            'choice_translation_domain' => false,
            'multiple' => false,
        ]);
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
