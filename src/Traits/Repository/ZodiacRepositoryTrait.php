<?php

namespace App\Traits\Repository;

use App\Entity\Repository\ZodiacRepository;

trait ZodiacRepositoryTrait
{
    /** @var ZodiacRepository $zodiacRepository */
    private $zodiacRepository;

    public function getZodiacRepository(): ZodiacRepository
    {
        return $this->zodiacRepository;
    }

    public function setZodiacRepository(ZodiacRepository $zodiacRepository): self
    {
        $this->zodiacRepository = $zodiacRepository;

        return $this;
    }
}
