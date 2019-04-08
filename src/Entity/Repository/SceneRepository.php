<?php

namespace App\Entity\Repository;

use App\Entity\Repository\AbstractBaseRepository;
use App\Entity\Scene;
use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SceneRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Scene::class);
    }
}
