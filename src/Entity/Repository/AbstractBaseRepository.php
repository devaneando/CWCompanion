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

    public function findAll(): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('ent')
            ->from($this->_entityName, 'ent')
            ->addOrderBy('ent.name', 'ASC');

        if (true === in_array(
            'predefined',
            $this->getEntityManager()->getClassMetadata($this->_entityName)->getColumnNames())
        ) {
            $queryBuilder->addOrderBy('ent.predefined', 'ASC');
        }

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function ensurePredefined(object $object)
    {
        if (false === in_array(
            'predefined',
            $this->getEntityManager()->getClassMetadata($this->_entityName)->getColumnNames())
        ) {
            return;
        }
        if (false === $object->isPredefined()) {
            return;
        }
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->update($this->_entityName, 'ent')
            ->set('ent.predefined', $queryBuilder->expr()->literal(false))
            ->where($queryBuilder->expr()->neq('ent.id', $queryBuilder->expr()->literal($object->getId())));
        $query = $queryBuilder->getQuery();
        $query->execute();
    }
}
