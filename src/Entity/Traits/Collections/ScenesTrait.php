<?php

namespace App\Entity\Traits\Collections;

use App\Entity\Scene;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

trait ScenesTrait
{
    /** @return PersistentCollection|ArrayCollection */
    public function getScenes()
    {
        return $this->scenes;
    }

    /** @param ArrayCollection|PersistentCollection|null $scenes */
    public function setScenes($scenes): self
    {
        $this->scenes = $scenes;

        return $this;
    }

    public function addScene(Scene $object): self
    {
        if (true === $this->scenes->contains($object)) {
            return $this;
        }
        $this->scenes->add($object);

        return $this;
    }

    public function removeScene(Scene $object): self
    {
        if (false === $this->scenes->contains($object)) {
            return $this;
        }
        $this->scenes->removeElement($object);

        return $this;
    }
}
