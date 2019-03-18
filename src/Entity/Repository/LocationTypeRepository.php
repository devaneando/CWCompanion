<?php

namespace App\Entity\Repository;

use App\Entity\LocationType;
use App\Entity\Repository\AbstractBaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class LocationTypeRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LocationType::class);
    }
}
