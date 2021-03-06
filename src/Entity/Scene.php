<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\OwnerTrait;
use App\Entity\Traits\Collections\CharactersTrait;
use App\Entity\Traits\Collections\KeyItemsTrait;
use App\Exception\Parameter\InvalidAmbient;
use App\Exception\Parameter\InvalidTime;
use App\Traits\ConstantValidationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\SceneRepository")
 * @ORM\Table(name="scenes",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_scenes_chapter_scene", columns={"chapter_id", "scene"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Scene
{
    const AMBIENT_EXTERIOR = 'EXT';
    const AMBIENT_INTERIOR = 'INT';
    const TIME_DAY = 'DAY';
    const TIME_NIGHT = 'NIGHT';

    use ConstantValidationTrait;

    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(name="id", type="uuid", unique=true)
     */
    protected $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="scenes")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=false)
     */
    protected $owner;
    use OwnerTrait;

    /**
     * @var Chapter
     * @ORM\ManyToOne(targetEntity="Chapter", inversedBy="scenes")
     * @ORM\JoinColumn(name="chapter_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull(message="not_null.chapter")
     */
    protected $chapter;

    /**
     * @var int
     * @ORM\Column(name="scene", type="integer", unique=false, nullable=false, options={"default":"0"})
     */
    protected $scene;

    /**
     * @var string
     * @ORM\Column(name="ambient", type="string", length=3, unique=false, nullable=false, options={"default":"INT"})
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     */
    protected $ambient;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="scenes")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    protected $location;

    /**
     * @var string
     * @ORM\Column(name="time", type="string", length=5, unique=false, nullable=false, options={"default":"DAY"})
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     */
    protected $time;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, unique=false, nullable=true)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;
    use DescriptionTrait;

    /**
     * @var string
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    protected $notes;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Character", inversedBy="scenes")
     * @ORM\JoinTable(
     *      name="scenes_characters",
     *      joinColumns={@ORM\JoinColumn(name="scene_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")}
     * )
     */
    protected $characters;
    use CharactersTrait;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="KeyItem", inversedBy="scenes")
     * @ORM\JoinTable(
     *      name="scenes_key_items",
     *      joinColumns={@ORM\JoinColumn(name="scene_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="key_item_id", referencedColumnName="id")}
     * )
     */
    protected $keyItems;
    use KeyItemsTrait;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
        $this->keyItems = new ArrayCollection();
    }

    /**
     * Get a string representation of the object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return (true === empty($this->getScene())) ? '' : $this->getScene();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getChapter(): ?Chapter
    {
        return $this->chapter;
    }

    public function setChapter(?Chapter $chapter): self
    {
        $this->chapter = $chapter;

        return $this;
    }

    public function getScene(): ?int
    {
        return $this->scene;
    }

    public function setScene(int $scene): self
    {
        $this->scene = $scene;

        return $this;
    }

    public function getAmbient(): ?string
    {
        return $this->ambient;
    }

    public function setAmbient(string $ambient): self
    {
        if (false === $this->isValidConstant($ambient, '/^AMBIENT_.*/')) {
            throw new InvalidAmbient();
        }
        $this->ambient = trim($ambient);

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        if (false === $this->isValidConstant($time, '/^TIME_.*/')) {
            throw new InvalidTime();
        }
        $this->time = trim($time);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(): self
    {
        $name = '';
        if (false === empty($this->getAmbient())) {
            $name .= $this->getAmbient() . '(' . $this->getScene() . ').';
        }
        if (false === empty($this->getLocation())) {
            $name .= ' -- ' . $this->getLocation()->getName();
        }
        if (false === empty($this->getTime())) {
            $name .= ' -- ' . $this->getTime();
        }
        $this->name = trim($name);

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preUpdateName()
    {
        $this->setName();
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = trim($description);

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = trim($notes);

        return $this;
    }
}
