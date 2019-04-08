<?php

namespace App\Entity\Repository;

use App\Entity\Project;
use App\Entity\Repository\AbstractBaseRepository;
use App\Entity\User;
use Doctrine\DBAL\FetchMode;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProjectRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }
}
