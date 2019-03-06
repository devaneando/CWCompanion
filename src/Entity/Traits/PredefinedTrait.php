<?php

namespace App\Entity\Traits;

trait PredefinedTrait
{
    public function isPredefined(): bool
    {
        return $this->predefined;
    }

    public function setPredefined(bool $predefined): self
    {
        $this->predefined = $predefined;

        return $this;
    }
}
