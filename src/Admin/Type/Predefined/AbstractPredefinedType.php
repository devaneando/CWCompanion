<?php

namespace App\Admin\Type\Predefined;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractPredefinedType extends SymfonyAbstractType
{
    /** @var string $class */
    protected $class;

    /** @var string $class */
    protected $blockPrefix;

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => $this->class,
            'required' => true,
            'choice_label' => 'name',
            'multiple' => false
        ]);

        $resolver->setDefault('query_builder', function (Options $options) {
            return function (EntityRepository $er) use ($options) {
                $queryBuilder = $er->createQueryBuilder('ent')
                    ->orderBy('ent.predefined', 'DESC')
                    ->addOrderBy('ent.name', 'ASC');
                return $queryBuilder;
            };
        });
    }

    /** {@inheritdoc} */
    public function getBlockPrefix()
    {
        return $this->blockPrefix;
    }

    /** {@inheritdoc} */
    public function getParent()
    {
        return EntityType::class;
    }
}
