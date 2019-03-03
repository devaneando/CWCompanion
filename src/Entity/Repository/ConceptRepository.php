<?php

namespace App\Entity\Repository;

use App\Entity\Concept;
use App\Entity\Repository\AbstractBaseRepository;
use App\Model\ExtendedDate;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ConceptRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, self::class);
    }
}
