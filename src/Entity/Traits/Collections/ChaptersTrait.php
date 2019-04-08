<?php

namespace App\Entity\Traits\Collections;

use App\Entity\Chapter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

trait ChaptersTrait
{
    /** @return PersistentCollection|ArrayCollection */
    public function getChapters()
    {
        return $this->chapters;
    }

    /** @param ArrayCollection|PersistentCollection|null $chapters */
    public function setChapters($chapters): self
    {
        $this->chapters = $chapters;

        return $this;
    }

    public function addChapter(Chapter $object): self
    {
        if (true === $this->chapters->contains($object)) {
            return $this;
        }
        $this->chapters->add($object);

        return $this;
    }

    public function removeChapter(Chapter $object): self
    {
        if (false === $this->chapters->contains($object)) {
            return $this;
        }
        $this->chapters->removeElement($object);

        return $this;
    }
}
