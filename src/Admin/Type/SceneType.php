<?php

namespace App\Admin\Type;

use App\Traits\LoggedUserTrait;
use App\Traits\Repository\SceneRepositoryTrait;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SceneType extends ChoiceType
{
    use LoggedUserTrait;
    use SceneRepositoryTrait;

    protected function getChapters(): array
    {
        return $this->getChapterRepository()->getChapterArrayByOwner($this->getLoggedUser());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => $this->getChapters(),
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
        return 'chapter';
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
