<?php

namespace App\Entity;

use App\Entity\Chapter;
use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\OwnerTrait;
use App\Entity\Traits\PictureTrait;
use App\Entity\User;
use App\Model\Image;
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
 *         @ORM\UniqueConstraint(name="unique_projects_owner_name", columns={"owner_id", "name"})
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
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="projects")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=false)
     */
    protected $owner;
    use OwnerTrait;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=120)
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     * @Assert\Length(
     *     max = 120,
     *     maxMessage="length.max.project.name"
     * )
     */
    protected $name;
    use NameTrait;

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
    protected $chapters;

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function setDefaultPicture(): self
    {
        if (null !== $this->picture) {
            return $this;
        }

        $image = ImageProcessor::IMAGE_PROJECT;
        $date = new \DateTime();
        $newImage = ImageProcessor::PATH_UPLOAD.'/'.$this->getId().'_'.$date->format('Ymd_His').'.png';
        if (false === file_exists(ImageProcessor::PATH_UPLOAD)) {
            mkdir(ImageProcessor::PATH_UPLOAD);
        }
        copy($image, $newImage);

        try {
            /** @var Image $image */
            $image = ImageProcessor::get($newImage);
            $image = ImageProcessor::move($image, ImageProcessor::IMAGE_TYPE_PROJECT, $this->getId());
            $this->picture = $image->getWebPath();

            return $this;
        } catch (\Exception $ex) {
            throw new \Exception(
                'Something unexpected happened in '.basename($ex->getFile()).'#'.$ex->getLine().': '.$ex->getMessage(),
                0,
                $ex
            );

            return $this;
        }
    }

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
