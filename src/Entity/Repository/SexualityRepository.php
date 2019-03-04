<?php

namespace App\Entity\Repository;

use App\Entity\Repository\AbstractBaseRepository;
use App\Entity\Sexuality;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SexualityRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Sexuality::class);
    }
}
