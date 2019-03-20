<?php

namespace App\Entity;

use App\Entity\Chapter;
use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\PictureTrait;
use App\Entity\Traits\SlugTrait;
use App\Processor\ImageProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\ProjectRepository")
 * @ORM\Table(name="projects",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_projects_name", columns={"name"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Project
{
    /** @var string */
    protected $pictureType = ImageProcessor::IMAGE_TYPE_PROJECT;

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

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=60, nullable=false)
     */
    protected $slug;
    use SlugTrait;

    /**
     * @var string
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    protected $picture;
    use PictureTrait;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;
    use DescriptionTrait;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Chapter", mappedBy="project")
     */
    private $chapters;

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getChapters(): ?ArrayCollection
    {
        return $this->chapters;
    }

    public function setChapters(?PersistentCollection $chapters): self
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
        $object->setProject($this);

        return $this;
    }

    public function removeChapter(Chapter $object): self
    {
        if (false === $this->chapters->contains($object)) {
            return $this;
        }
        $this->chapters->removeElement($object);
        $object->setProject(null);

        return $this;
    }
}