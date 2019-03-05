<?php

namespace App\Entity\Traits;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;

trait SlugTrait
{
    /** @return string */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = trim($name);
        $this->setSlug();

        return $this;
    }

    /** @return string */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return self
     */
    protected function setSlug(): self
    {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($this->name);

        return $this;
    }

    /**
     * Get a string representation of the object.
     *
     * @return string
     */
    public function __toString(): string
    {
        if (true === empty($this->name)) {
            return '';
        }

        return $this->getName();
    }

    /**
     * @ORM\PrePersist()
     *
     * @return self
     */
    public function onPrePersistSlug(): self
    {
        $this->setSlug();

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     *
     * @return self
     */
    public function onPreUpdateSlug(): self
    {
        $this->setSlug();

        return $this;
    }
}
