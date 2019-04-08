<?php

namespace App\Entity\Traits\Collections;

use App\Entity\Character;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

trait CharactersTrait
{
    /** @return PersistentCollection|ArrayCollection */
    public function getCharacters()
    {
        return $this->characters;
    }

    /** @param ArrayCollection|PersistentCollection|null $characters */
    public function setCharacters($characters): self
    {
        $this->characters = $characters;

        return $this;
    }

    public function addCharacter(Character $object): self
    {
        if (true === $this->characters->contains($object)) {
            return $this;
        }
        $this->characters->add($object);

        return $this;
    }

    public function removeCharacter(Character $object): self
    {
        if (false === $this->characters->contains($object)) {
            return $this;
        }
        $this->characters->removeElement($object);

        return $this;
    }
}
