<?php

namespace App\Entity\Traits;

use App\Entity\User;

trait OwnerTrait
{
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
