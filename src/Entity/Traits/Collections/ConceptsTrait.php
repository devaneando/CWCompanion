<?php

namespace App\Entity\Traits\Collections;

use App\Entity\Concept;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

trait ConceptsTrait
{
    /** @return PersistentCollection|ArrayCollection */
    public function getConcepts()
    {
        return $this->concepts;
    }

    /** @param ArrayCollection|PersistentCollection|null $concepts */
    public function setConcepts($concepts): self
    {
        $this->concepts = $concepts;

        return $this;
    }

    public function addConcept(Concept $object): self
    {
        if (true === $this->concepts->contains($object)) {
            return $this;
        }
        $this->concepts->add($object);

        return $this;
    }

    public function removeConcept(Concept $object): self
    {
        if (false === $this->concepts->contains($object)) {
            return $this;
        }
        $this->concepts->removeElement($object);

        return $this;
    }
}
