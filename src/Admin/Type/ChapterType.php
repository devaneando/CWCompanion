<?php

namespace App\Admin\Type;

use App\Traits\LoggedUserTrait;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType as SymfonyAbstractType;

class ChapterType extends SymfonyAbstractType
{
    use LoggedUserTrait;

    public function configureOptions(OptionsResolver $resolver)
    {
        if (false === $this->getLoggedUser()->isSuperAdmin()) {
            $resolver->setDefault('query_builder', function (Options $options) {
                return function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('cha')
                        ->orderBy('cha.name', 'ASC')
                        ->andWhere('cha.owner = :owner')
                        ->setParameter('owner', $this->getLoggedUser());
                };
            });
        }
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
        return EntityType::class;
    }
}
