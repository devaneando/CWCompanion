<?php

namespace App\Entity\Repository;

use App\Entity\Repository\AbstractBaseRepository;
use App\Entity\Zodiac;
use App\Model\ExtendedDate;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ZodiacRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Zodiac::class);
    }

    public function findSignByExtendedDate(ExtendedDate $extendedDate): ?Zodiac
    {
        $date = \DateTime::createFromFormat(
            'Y-m-d',
            '2019-'.$extendedDate->monthAsString().'-'.$extendedDate->dayAsString()
        );
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('zod')
            ->from(Zodiac::class, 'zod')
            ->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->between(':date', 'zod.start', 'zod.end'),
                    $queryBuilder->expr()->between(':date', 'zod.startComplementary', 'zod.endComplementary')
                )
            );
        $query = $queryBuilder->getQuery();
        $query->setParameter('date', $date);

        return $query->getOneOrNullResult();
    }
}
