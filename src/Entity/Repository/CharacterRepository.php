<?php

namespace App\Entity\Repository;

use App\Entity\Character;
use App\Entity\Repository\AbstractBaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CharacterRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Character::class);
    }
}
