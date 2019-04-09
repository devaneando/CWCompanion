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
        if (null === $this->locations) {
            $this->setLocations();
        }
        return $this->locations;
    }

    /** @param ArrayCollection|PersistentCollection|null $locations */
    public function setLocations($locations = null): self
    {
        $this->locations = $locations;
        if (null === $locations) {
            $this->locations = new ArrayCollection();
        }

        return $this;
    }

    public function addLocation(Location $object): self
    {
        if (true === $this->getLocations()->contains($object)) {
            return $this;
        }
        $this->getLocations()->add($object);

        return $this;
    }

    public function removeLocation(Location $object): self
    {
        if (false === $this->getLocations()->contains($object)) {
            return $this;
        }
        $this->getLocations()->removeElement($object);

        return $this;
    }
}
