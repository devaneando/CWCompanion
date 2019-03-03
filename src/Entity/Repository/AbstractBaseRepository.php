<?php

namespace App\Entity\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Comparison;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class AbstractBaseRepository extends ServiceEntityRepository
{
    /**
     * @param object $object
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function persist(object $object): object
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();

        return $object;
    }

    public function getRandom(): object
    {
        $items = $this->findAll();

        return $items[rand(0, count($items) - 1)];
    }
}
