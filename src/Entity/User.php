<?php

namespace App\Entity;

use App\Entity\Chapter;
use App\Entity\Character;
use App\Entity\Concept;
use App\Entity\KeyItem;
use App\Entity\Location;
use App\Entity\Project;
use App\Entity\Scene;
use App\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\UserRepository")
 * @ORM\Table(name="users",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_users_confirmation_token", columns={"confirmation_token"}),
 *         @ORM\UniqueConstraint(name="unique_users_email_canonical", columns={"email_canonical"}),
 *         @ORM\UniqueConstraint(name="unique_users_name", columns={"name"}),
 *         @ORM\UniqueConstraint(name="unique_users_username_canonical", columns={"username_canonical"}),
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=120, unique=true)
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     */
    protected $name;
    use NameTrait;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Project", mappedBy="owner")
     */
    protected $projects;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Chapter", mappedBy="owner")
     */
    protected $chapters;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Scene", mappedBy="owner")
     */
    protected $scenes;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Character", mappedBy="owner")
     */
    protected $characters;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Concept", mappedBy="owner")
     */
    protected $concepts;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="KeyItem", mappedBy="owner")
     */
    protected $keyItems;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Location", mappedBy="owner")
     */
    protected $locations;

    public function __construct()
    {
        parent::__construct();
        $this->projects = new ArrayCollection();
        $this->chapters = new ArrayCollection();
        $this->scenes = new ArrayCollection();
        $this->characters = new ArrayCollection();
        $this->concepts = new ArrayCollection();
        $this->keyItems = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /** @return ArrayCollection|PersistentCollection */
    public function getProjects()
    {
        return $this->projects;
    }

    /** @param ArrayCollection|PersistentCollection|null $projects */
    public function setProjects($projects): self
    {
        $this->projects = $projects;

        return $this;
    }

    public function addProject(Project $project): self
    {
        if (true === $this->projects->contains($project)) {
            return $this;
        }
        $this->projects->add($project);
        $project->setOwner($this);

        return $this;
    }

    public function getChapters()
    {
        return $this->chapters;
    }

    public function setChapters($chapters): self
    {
        $this->chapters = $chapters;

        return $this;
    }

    public function addChapter(Chapter $chapter): self
    {
        if (true === $this->chapters->contains($chapter)) {
            return $this;
        }
        $this->chapters->add($chapter);
        $chapter->setOwner($this);

        return $this;
    }

    public function getScenes()
    {
        return $this->scenes;
    }

    public function setScenes($scenes): self
    {
        $this->scenes = $scenes;

        return $this;
    }

    public function addScene(Scene $scene): self
    {
        if (true === $this->scenes->contains($scene)) {
            return $this;
        }
        $this->scenes->add($scene);
        $scene->setOwner($this);

        return $this;
    }

    public function getCharacters()
    {
        return $this->characters;
    }

    public function setCharacters($characters): self
    {
        $this->characters = $characters;

        return $this;
    }

    public function addCharacter(Character $character): self
    {
        if (true === $this->characters->contains($character)) {
            return $this;
        }
        $this->characters->add($character);
        $character->setOwner($this);

        return $this;
    }

    public function getConcepts()
    {
        return $this->concepts;
    }

    public function setConcepts($concepts): self
    {
        $this->concepts = $concepts;

        return $this;
    }

    public function addConcept(Concept $concept): self
    {
        if (true === $this->concepts->contains($concept)) {
            return $this;
        }
        $this->concepts->add($concept);
        $concept->setOwner($this);

        return $this;
    }

    public function getKeyItems()
    {
        return $this->keyItems;
    }

    public function setKeyItems($keyItems): self
    {
        $this->keyItems = $keyItems;

        return $this;
    }

    public function addKeyItem(KeyItem $keyItem): self
    {
        if (true === $this->keyItems->contains($keyItem)) {
            return $this;
        }
        $this->keyItems->add($keyItem);
        $keyItem->setOwner($this);

        return $this;
    }

    public function getLocations()
    {
        return $this->locations;
    }

    public function setLocations($locations): self
    {
        $this->locations = $locations;

        return $this;
    }

    public function addLocation(Location $location): self
    {
        if (true === $this->locations->contains($location)) {
            return $this;
        }
        $this->locations->add($location);
        $location->setOwner($this);

        return $this;
    }
}
