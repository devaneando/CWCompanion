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
        $monthDate = $extendedDate->getMonthAsString().'-'.$extendedDate->getDayAsString();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('zod')
            ->from(Zodiac::class, 'zod')
            ->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->between(':monthDate', 'zod.startMonthDay', 'zod.endMonthDay'),
                    $queryBuilder->expr()->between(':monthDate', 'zod.startMonthDayComplementary', 'zod.endMonthDayComplementary')
                )
            );
        $query = $queryBuilder->getQuery();
        $query->setParameter('monthDate', $monthDate);

        return $query->getOneOrNullResult();
    }
}
