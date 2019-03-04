<?php

namespace App\Entity\Traits;

trait DescriptionTrait
{
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description = null): self
    {
        $this->description = trim($description);

        return $this;
    }
}
