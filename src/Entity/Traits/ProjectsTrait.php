<?php

namespace App\Entity\Traits;

use App\Entity\Project;
use Doctrine\Common\Collections\ArrayCollection;

trait ProjectsTrait
{
    public function setProjectsAsArray($projects = null): self
    {
        if (null === $projects) {
            $this->projects = new ArrayCollection();
        }

        if (true === is_array($projects)) {
            $projects = new ArrayCollection($projects);
        }
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
