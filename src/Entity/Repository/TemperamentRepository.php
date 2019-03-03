<?php

namespace App\Entity\Repository;

use App\Entity\Repository\AbstractBaseRepository;
use App\Entity\Temperament;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TemperamentRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Temperament::class);
    }
}
