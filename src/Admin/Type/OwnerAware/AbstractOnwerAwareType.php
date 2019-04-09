<?php

namespace App\Admin\Type\OwnerAware;

use App\Traits\LoggedUserTrait;
use App\Traits\RouterTrait;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractOnwerAwareType extends SymfonyAbstractType
{
    use LoggedUserTrait;
    use RouterTrait;

    /** @var string $class */
    protected $class;

    /** @var string $class */
    protected $blockPrefix;

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => $this->class,
            'required' => false,
            'choice_label' => 'name',
            'multiple' => true
        ]);

        if (false === $this->getLoggedUser()->isSuperAdmin()) {
            $resolver->setDefault('query_builder', function (Options $options) {
                return function (EntityRepository $er) use ($options) {
                    $matches = [];
                    preg_match(
                        '/^.*\/([0-9a-z\-]+)\/edit$/',
                        $this->getRouter()->getContext()->getPathInfo(),
                        $matches
                    );

                    $queryBuilder = $er->createQueryBuilder('ent')
                        ->orderBy('ent.name', 'ASC')
                        ->andWhere('ent.owner = :owner')
                        ->setParameter('owner', $this->getLoggedUser());
                    if (true === array_key_exists('1', $matches)) {
                        $queryBuilder
                            ->andWhere('ent.id != :id')
                            ->setParameter('id', $matches[1]);
                    }
                    return $queryBuilder;
                };
            });
        }
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
