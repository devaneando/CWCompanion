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
        if (null === $this->characters) {
            $this->setCharacters();
        }
        return $this->characters;
    }

    /** @param ArrayCollection|PersistentCollection|null $characters */
    public function setCharacters($characters = null): self
    {
        $this->characters = $characters;
        if (null === $characters) {
            $this->characters = new ArrayCollection();
        }

        return $this;
    }

    public function addCharacter(Character $object): self
    {
        if (true === $this->getCharacters()->contains($object)) {
            return $this;
        }
        $this->getCharacters()->add($object);

        return $this;
    }

    public function removeCharacter(Character $object): self
    {
        if (false === $this->getCharacters()->contains($object)) {
            return $this;
        }
        $this->getCharacters()->removeElement($object);

        return $this;
    }
}
