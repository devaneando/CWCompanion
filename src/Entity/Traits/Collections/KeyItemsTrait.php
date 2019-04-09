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
        if (null === $this->keyItems) {
            $this->setKeyItems();
        }
        return $this->keyItems;
    }

    /** @param ArrayCollection|PersistentCollection|null $keyItems */
    public function setKeyItems($keyItems = null): self
    {
        $this->keyItems = $keyItems;
        if (null === $keyItems) {
            $this->keyItems = new ArrayCollection();
        }

        return $this;
    }

    public function addKeyItem(KeyItem $object): self
    {
        if (true === $this->getKeyItems()->contains($object)) {
            return $this;
        }
        $this->getKeyItems()->add($object);

        return $this;
    }

    public function removeKeyItem(KeyItem $object): self
    {
        if (false === $this->getKeyItems()->contains($object)) {
            return $this;
        }
        $this->getKeyItems()->removeElement($object);

        return $this;
    }
}
