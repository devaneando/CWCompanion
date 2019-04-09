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
        if (null === $this->chapters) {
            $this->setChapters();
        }
        return $this->chapters;
    }

    /** @param ArrayCollection|PersistentCollection|null $chapters */
    public function setChapters($chapters = null): self
    {
        $this->chapters = $chapters;
        if (null === $chapters) {
            $this->chapters = new ArrayCollection();
        }

        return $this;
    }

    public function addChapter(Chapter $object): self
    {
        if (true === $this->getChapters()->contains($object)) {
            return $this;
        }
        $this->getChapters()->add($object);

        return $this;
    }

    public function removeChapter(Chapter $object): self
    {
        if (false === $this->getChapters()->contains($object)) {
            return $this;
        }
        $this->getChapters()->removeElement($object);

        return $this;
    }
}
