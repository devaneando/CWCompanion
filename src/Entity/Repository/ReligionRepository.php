<?php

namespace App\Entity\Repository;

use App\Entity\Religion;
use App\Entity\Repository\AbstractBaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ReligionRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Religion::class);
    }
}
