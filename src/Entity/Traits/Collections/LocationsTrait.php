<?php

namespace App\Entity\Traits\Collections;

use App\Entity\Location;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

trait LocationsTrait
{
    /** @return PersistentCollection|ArrayCollection */
    public function getLocations()
    {
        return $this->locations;
    }

    /** @param ArrayCollection|PersistentCollection|null $locations */
    public function setLocations($locations): self
    {
        $this->locations = $locations;

        return $this;
    }

    public function addLocation(Location $object): self
    {
        if (true === $this->locations->contains($object)) {
            return $this;
        }
        $this->locations->add($object);

        return $this;
    }

    public function removeLocation(Location $object): self
    {
        if (false === $this->locations->contains($object)) {
            return $this;
        }
        $this->locations->removeElement($object);

        return $this;
    }
}
