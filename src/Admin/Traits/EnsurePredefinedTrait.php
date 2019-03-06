<?php

namespace App\Admin\Traits;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

trait EnsurePredefinedTrait
{
    /** @var ServiceEntityRepositoryInterface */
    protected $repository;

    public function getRepository(): ServiceEntityRepositoryInterface
    {
        return $this->repository;
    }

    public function setRepository(ServiceEntityRepositoryInterface $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function postUpdate($object)
    {
        $this->repository->ensurePredefined($object);
    }

    public function postPersist($object)
    {
        $this->repository->ensurePredefined($object);
    }
}
