<?php

namespace App\Entity\Repository;

use App\Entity\Repository\AbstractBaseRepository;
use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }
}
