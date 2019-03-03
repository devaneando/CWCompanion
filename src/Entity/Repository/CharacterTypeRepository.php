<?php

namespace App\Entity\Repository;

use App\Entity\CharacterType;
use App\Entity\Repository\AbstractBaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CharacterTypeRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CharacterType::class);
    }
}
