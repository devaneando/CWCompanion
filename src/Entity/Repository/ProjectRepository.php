<?php

namespace App\Entity\Repository;

use App\Entity\Project;
use App\Entity\Repository\AbstractBaseRepository;
use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProjectRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function userHasProjects(User $user): bool
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('COUNT(pro)')
            ->from(Project::class, 'pro')
            ->where('pro.owner = :owner');
        $query = $queryBuilder->getQuery();
        $query->setParameter('owner', $user);

        return (0 >= $query->getSingleScalarResult()) ? false : true;
    }
}
