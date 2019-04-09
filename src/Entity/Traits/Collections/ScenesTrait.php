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
        if (null === $this->scenes) {
            $this->setScenes();
        }
        return $this->scenes;
    }

    /** @param ArrayCollection|PersistentCollection|null $scenes */
    public function setScenes($scenes = null): self
    {
        $this->scenes = $scenes;
        if (null === $scenes) {
            $this->scenes = new ArrayCollection();
        }

        return $this;
    }

    public function addScene(Scene $object): self
    {
        if (true === $this->getScenes()->contains($object)) {
            return $this;
        }
        $this->getScenes()->add($object);

        return $this;
    }

    public function removeScene(Scene $object): self
    {
        if (false === $this->getScenes()->contains($object)) {
            return $this;
        }
        $this->getScenes()->removeElement($object);

        return $this;
    }
}
