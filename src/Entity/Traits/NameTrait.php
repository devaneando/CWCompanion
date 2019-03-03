<?php

namespace App\Entity\Traits;

trait NameTrait
{
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = trim($name);

        return $this;
    }

    public function __toString(): string
    {
        return (true === empty($this->getName())) ? '' : $this->getName();
    }
}
