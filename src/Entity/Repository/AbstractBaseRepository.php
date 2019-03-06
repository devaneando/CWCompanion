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

        if (true === in_array('predefined', $this->getEntityManager()->getClassMetadata()->getColumnNames())) {
            $queryBuilder->addOrderBy('ent.predefined', 'ASC');
        }

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function ensurePredefined(object $object, bool $predefined)
    {
        if (false === in_array('predefined', $this->getEntityManager()->getClassMetadata()->getColumnNames())) {
            return;
        }
        if (false === $predefined) {
            return;
        }
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->update($this->_entityName, 'ent')
            ->set('ent.predefined', false)
            ->where('ent.id != object');
        $query = $queryBuilder->getQuery();
        $query->setParameter('object', $object->getId());
        $query->execute();
    }
}
