<?php

namespace App\Entity;

use App\Entity\Chapter;
use App\Entity\Character;
use App\Entity\KeyItem;
use App\Entity\Location;
use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\OwnerTrait;
use App\Entity\User;
use App\Exception\Parameter\InvalidAmbient;
use App\Exception\Parameter\InvalidTime;
use App\Traits\ConstantValidationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
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
    public function __toString() : string
    {
        return (true === empty($this->getScene())) ? '' : $this->getScene();
    }

    public function getId() : ? UuidInterface
    {
        return $this->id;
    }

    public function getChapter() : ? Chapter
    {
        return $this->chapter;
    }

    public function setChapter(? Chapter $chapter) : self
    {
        $this->chapter = $chapter;

        return $this;
    }

    public function getScene() : ? int
    {
        return $this->scene;
    }

    public function setScene(int $scene) : self
    {
        $this->scene = $scene;

        return $this;
    }

    public function getAmbient() : ? string
    {
        return $this->ambient;
    }

    public function setAmbient(string $ambient) : self
    {
        if (false === $this->isValidConstant($ambient, '/^AMBIENT_.*/')) {
            throw new InvalidAmbient();
        }
        $this->ambient = trim($ambient);

        return $this;
    }

    public function getLocation() : ? Location
    {
        return $this->location;
    }

    public function setLocation(? Location $location) : self
    {
        $this->location = $location;

        return $this;
    }

    public function getTime() : ? string
    {
        return $this->time;
    }

    public function setTime(string $time) : self
    {
        if (false === $this->isValidConstant($time, '/^TIME_.*/')) {
            throw new InvalidTime();
        }
        $this->time = trim($time);

        return $this;
    }

    public function getDescription() : ? string
    {
        return $this->description;
    }

    public function setDescription(? string $description) : self
    {
        $this->description = trim($description);

        return $this;
    }

    public function getNotes() : ? string
    {
        return $this->notes;
    }

    public function setNotes(? string $notes) : self
    {
        $this->notes = trim($notes);

        return $this;
    }

    /** @return ArrayCollection|PersistentCollection */
    public function getCharacters()
    {
        return $this->characters;
    }

    /** @param ArrayCollection|PersistentCollection|null $characters */
    public function setCharacters($characters) : self
    {
        $this->characters = $characters;

        return $this;
    }

    public function addCharacter(Character $object) : self
    {
        if (true === $this->characters->contains($object)) {
            return $this;
        }
        $this->characters->add($object);
        $object->addScene($this);

        return $this;
    }

    public function removeCharacter(Character $object) : self
    {
        if (false === $this->characters->contains($object)) {
            return $this;
        }
        $this->characters->removeElement($object);
        $object->removeScene($this);

        return $this;
    }

    /** @return ArrayCollection|PersistentCollection */
    public function getKeyItems()
    {
        return $this->keyItems;
    }

    /** @param ArrayCollection|PersistentCollection|null $keyItems */
    public function setKeyItems($keyItems) : self
    {
        $this->keyItems = $keyItems;

        return $this;
    }

    public function addKeyItem(KeyItem $object) : self
    {
        if (true === $this->keyItems->contains($object)) {
            return $this;
        }
        $this->keyItems->add($object);
        $object->addScene($this);

        return $this;
    }

    public function removeKeyItem(KeyItem $object) : self
    {
        if (false === $this->keyItems->contains($object)) {
            return $this;
        }
        $this->keyItems->removeElement($object);
        $object->removeScene($this);

        return $this;
    }
}
