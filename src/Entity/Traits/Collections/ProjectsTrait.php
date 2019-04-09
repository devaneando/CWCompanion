<?php

namespace App\Entity\Traits\Collections;

use App\Entity\Project;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use phpDocumentor\Reflection\Types\This;

trait ProjectsTrait
{
    /** @return PersistentCollection|ArrayCollection */
    public function getProjects()
    {
        if (null === $this->projects) {
            $this->setProjects();
        }
        return $this->projects;
    }

    /** @param ArrayCollection|PersistentCollection|null $projects */
    public function setProjects($projects = null): self
    {
        $this->projects = $projects;
        if (null === $projects) {
            $this->projects = new ArrayCollection();
        }

        return $this;
    }

    public function addProject(Project $object): self
    {
        if (true === $this->getProjects()->contains($object)) {
            return $this;
        }
        $this->getProjects()->add($object);

        return $this;
    }

    public function removeProject(Project $object): self
    {
        if (false === $this->getProjects()->contains($object)) {
            return $this;
        }
        $this->getProjects()->removeElement($object);

        return $this;
    }
}
