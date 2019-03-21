<?php

namespace App\Admin\Type;

use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeType extends SymfonyAbstractType
{
    const TIME_DAY = 'DAY';
    const TIME_NIGHT = 'NIGHT';

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'time.DAY' => self::TIME_DAY,
                'time.NIGHT' => self::TIME_NIGHT,
            ],
            'choices_as_values' => true,
            'choice_translation_domain' => 'scene',
            'data' => self::TIME_NIGHT,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'time_scene';
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
