<?php

namespace App\Entity\Traits\Collections;

use App\Entity\Project;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

trait ProjectsTrait
{
    /** @return PersistentCollection|ArrayCollection */
    public function getProjects()
    {
        return $this->projects;
    }

    /** @param ArrayCollection|PersistentCollection|null $projects */
    public function setProjects($projects = null): self
    {
        $this->projects = $projects;

        return $this;
    }

    public function addProject(Project $object): self
    {
        if (true === $this->projects->contains($object)) {
            return $this;
        }
        $this->projects->add($object);

        return $this;
    }

    public function removeProject(Project $object): self
    {
        if (false === $this->projects->contains($object)) {
            return $this;
        }
        $this->projects->removeElement($object);

        return $this;
    }
}
