<?php

namespace App\Admin\Type\OwnerAware;

use App\Admin\Type\OwnerAware\AbstractOnwerAwareType;
use App\Entity\Character;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Repository\CharacterRepository;

class CharacterType extends AbstractOnwerAwareType
{
    /** @var string $class */
    protected $class = Character::class;

    /** @var string $class */
    protected $blockPrefix = 'character_type';

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => $this->class,
            'required' => false,
            'choice_label' => 'nickname',
            'multiple' => true
        ]);

        if (false === $this->getLoggedUser()->isSuperAdmin()) {
            $resolver->setDefault('query_builder', function (Options $options) {
                return function (CharacterRepository $er) use ($options) {
                    $matches = [];
                    preg_match(
                        '/^.*\/([0-9a-z\-]+)\/edit$/',
                        $this->getRouter()->getContext()->getPathInfo(),
                        $matches
                    );

                    $queryBuilder = $er->createQueryBuilder('ent')
                        ->orderBy('ent.nickname', 'ASC')
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
}
