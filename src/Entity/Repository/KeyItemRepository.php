<?php

namespace App\Entity\Repository;

use App\Entity\KeyItem;
use App\Entity\Repository\AbstractBaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class KeyItemRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, KeyItem::class);
    }
}
