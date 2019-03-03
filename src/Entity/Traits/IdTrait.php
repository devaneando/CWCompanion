<?php

namespace App\Entity\Traits;

trait IdTrait
{
    public function getId(): ?int
    {
        return $this->id;
    }
}
