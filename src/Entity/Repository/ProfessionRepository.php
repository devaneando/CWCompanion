<?php

namespace App\Entity\Repository;

use App\Entity\Profession;
use App\Entity\Repository\AbstractBaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProfessionRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Profession::class);
    }
}
