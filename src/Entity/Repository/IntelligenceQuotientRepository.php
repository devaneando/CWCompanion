<?php

namespace App\Entity\Repository;

use App\Entity\IntelligenceQuotient;
use App\Entity\Repository\AbstractBaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class IntelligenceQuotientRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IntelligenceQuotient::class);
    }
}
