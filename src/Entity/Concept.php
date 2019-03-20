<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Model\Image;
use App\Processor\ImageProcessor;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\ConceptRepository")
 * @ORM\Table(name="concepts",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_concepts_name", columns={"name"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Concept
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

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Concept", mappedBy="parent")
     */
    private $children;

    /**
     * @var self
     * @ORM\ManyToOne(targetEntity="Concept", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var string
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    protected $picture;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=60, nullable=false)
     */
    protected $slug;

    /**
     * @var string
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    protected $content;

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

    public function getChildren(): ?PersistentCollection
    {
        return $this->children;
    }

    public function setChildren(?PersistentCollection $children): self
    {
        $this->children = $children;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture = null): self
    {
        $this->picture = trim($picture);

        return $this;
    }

    public function getUploadedPicture(): ?string
    {
        return $this->picture;
    }

    public function setUploadedPicture(UploadedFile $uploadedPicture = null): self
    {
        if (null === $uploadedPicture) {
            return $this;
        }

        /** @var Image $image */
        $image = ImageProcessor::get(ImageProcessor::upload($uploadedPicture));
        $image = ImageProcessor::move($image, ImageProcessor::IMAGE_TYPE_LOCALE, $this->getId());
        $this->picture = $image->getWebPath();

        return $this;
    }

    public function setDefaultPicture(): self
    {
        if (null !== $this->picture) {
            return $this;
        }

        $image = ImageProcessor::IMAGE_LOCALE;
        $date = new \DateTime();
        $newImage = ImageProcessor::PATH_UPLOAD.'/'.$this->getId().'_'.$date->format('Ymd_His').'.png';
        if (false === file_exists(ImageProcessor::PATH_UPLOAD)) {
            mkdir(ImageProcessor::PATH_UPLOAD);
        }
        copy($image, $newImage);

        try {
            /** @var Image $image */
            $image = ImageProcessor::get($newImage);
            $image = ImageProcessor::move($image, ImageProcessor::IMAGE_TYPE_LOCALE, $this->getId());
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = trim($content);

        return $this;
    }
}
