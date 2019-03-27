<?php

namespace App\Entity\Repository;

use App\Entity\Concept;
use App\Entity\Repository\AbstractBaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ConceptRepository extends AbstractBaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Concept::class);
    }

    public function findBySlug(string $slug): ?self
    {
        return $this->findOneBy(['slug' => trim($slug)]);
    }
}
