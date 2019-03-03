<?php

namespace App\Entity\Repository;

use App\Entity\EducationalDegree;
use App\Entity\Repository\AbstractBaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EducationalDegreeRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EducationalDegree::class);
    }
}
