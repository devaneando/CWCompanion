<?php

namespace App\Entity;

use App\Entity\Project;
use App\Entity\Scene;
use App\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\ChapterRepository")
 * @ORM\Table(name="chapters",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_chapters_name", columns={"name"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Chapter
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
    use NameTrait;

    /**
     * @var Project
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="chapters")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Scene", mappedBy="chapter")
     */
    private $scenes;

    /**
     * @var string
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    protected $content;

    public function __construct()
    {
        $date = new \DateTime();
        $this->setName($date->format('Y-m-d'));
        $this->scenes = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getScenes(): ?ArrayCollection
    {
        return $this->scenes;
    }

    public function setScenes(?PersistentCollection $scenes): self
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
        $object->setChapter($this);

        return $this;
    }

    public function removeScene(Scene $object): self
    {
        if (false === $this->scenes->contains($object)) {
            return $this;
        }
        $this->scenes->removeElement($object);
        $object->setChapter(null);

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = trim($content);

        return $this;
    }
}
