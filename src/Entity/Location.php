<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\PredefinedTrait;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\LocationRepository")
 * @ORM\Table(name="locations",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_locations_name", columns={"name"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Location
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(name="id", type="uuid", unique=true)
     */
    protected $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Location", mappedBy="parent")
     */
    private $children;

    /**
     * @var self
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=120, unique=true)
     * @Assert\NotNull(message="validator.not_blank")
     * @Assert\NotBlank(message="validator.not_blank")
     * @Assert\Length(
     *     max = 120,
     *     maxMessage="validator.length_max.name"
     * )
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=60, nullable=false)
     */
    protected $slug;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;
    use DescriptionTrait;

    /**
     * @var string
     * @ORM\Column(name="history", type="text", nullable=true)
     */
    protected $history;

    /**
     * @var string
     * @ORM\Column(name="general_notes", type="text", nullable=true)
     */
    protected $generalNotes;

    /**
     * @var bool
     * @ORM\Column(name="predefined", type="boolean", nullable=true)
     */
    protected $predefined = false;
    use PredefinedTrait;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function addChild(self $child): self
    {
        if ($this === $child) {
            return $this;
        }
        if (true === $this->children->contains($child)) {
            return $this;
        }
        $this->children->add($child);
        $child->setParent($this);

        return $this;
    }

    public function removeChild(self $child): self
    {
        if (false === $this->children->contains($child)) {
            return $this;
        }
        $this->children->remove($child);
        $child->setParent(null);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = trim($name);
        $this->setSlug();

        return $this;
    }

    public function __toString(): string
    {
        return (true === empty($this->getName())) ? '' : $this->getName();
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(): self
    {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($this->name);

        return $this;
    }

    public function getHistory(): ?string
    {
        return $this->history;
    }

    public function setHistory(string $history): self
    {
        $this->history = trim($history);

        return $this;
    }

    public function getGeneralNotes(): ?string
    {
        return $this->generalNotes;
    }

    public function setGeneralNotes(string $generalNotes): self
    {
        $this->generalNotes = trim($generalNotes);

        return $this;
    }
}
