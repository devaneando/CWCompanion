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
        if (null === $this->concepts) {
            $this->setConcepts();
        }
        return $this->concepts;
    }

    /** @param ArrayCollection|PersistentCollection|null $concepts */
    public function setConcepts($concepts = null): self
    {
        $this->concepts = $concepts;
        if (null === $concepts) {
            $this->concepts = new ArrayCollection();
        }

        return $this;
    }

    public function addConcept(Concept $object): self
    {
        if (true === $this->getConcepts()->contains($object)) {
            return $this;
        }
        $this->getConcepts()->add($object);

        return $this;
    }

    public function removeConcept(Concept $object): self
    {
        if (false === $this->getConcepts()->contains($object)) {
            return $this;
        }
        $this->getConcepts()->removeElement($object);

        return $this;
    }
}
