<?php

namespace App\Entity\Traits\Collections;

use App\Entity\KeyItem;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

trait KeyItemsTrait
{
    /** @return PersistentCollection|ArrayCollection */
    public function getKeyItems()
    {
        return $this->keyItems;
    }

    /** @param ArrayCollection|PersistentCollection|null $keyItems */
    public function setKeyItems($keyItems) : self
    {
        $this->keyItems = $keyItems;

        return $this;
    }

    public function addKeyItem(KeyItem $object) : self
    {
        if (true === $this->keyItems->contains($object)) {
            return $this;
        }
        $this->keyItems->add($object);

        return $this;
    }

    public function removeKeyItem(KeyItem $object) : self
    {
        if (false === $this->keyItems->contains($object)) {
            return $this;
        }
        $this->keyItems->removeElement($object);

        return $this;
    }
}
