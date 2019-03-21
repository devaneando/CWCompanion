<?php

namespace App\Admin\Type;

use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AmbientType extends SymfonyAbstractType
{
    const AMBIENT_EXTERIOR = 'EXT';
    const AMBIENT_INTERIOR = 'INT';

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'ambient.EXT' => self::AMBIENT_EXTERIOR,
                'ambient.INT' => self::AMBIENT_INTERIOR,
            ],
            'choices_as_values' => true,
            'choice_translation_domain' => 'scene',
            'data' => self::AMBIENT_INTERIOR,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ambient';
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
