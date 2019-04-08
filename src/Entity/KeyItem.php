<?php

namespace App\Entity;

use App\Entity\Scene;
use App\Entity\Traits\Collections\ProjectsTrait;
use App\Entity\Traits\Collections\ScenesTrait;
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
 * @ORM\Entity(repositoryClass="App\Entity\Repository\KeyItemRepository")
 * @ORM\Table(name="key_items",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_key_items_name", columns={"name"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class KeyItem
{
    /** @var string */
    protected $pictureType = ImageProcessor::IMAGE_TYPE_KEY_ITEM;

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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="keyItems")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=false)
     */
    protected $owner;
    use OwnerTrait;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", inversedBy="keyItems")
     * @ORM\JoinTable(name="key_items_projects",
     *     joinColumns={@ORM\JoinColumn(name="key_items_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")}
     * )
     */
    protected $projects;
    use ProjectsTrait;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Scene", mappedBy="keyItems")
     */
    protected $scenes;
    use ScenesTrait;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=120, unique=true)
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     * @Assert\Length(
     *     max = 120,
     *     maxMessage="length.max.key_item.name"
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
     * @var string
     * @ORM\Column(name="history", type="text", nullable=true)
     */
    protected $history;

    /**
     * @var string
     * @ORM\Column(name="general_notes", type="text", nullable=true)
     */
    protected $generalNotes;

    public function __construct()
    {
        $this->scenes = new ArrayCollection();
    }

    public function getId() : ? UuidInterface
    {
        return $this->id;
    }

    public function setDefaultPicture() : self
    {
        if (null !== $this->picture) {
            return $this;
        }

        $image = ImageProcessor::IMAGE_KEY_ITEM;
        $date = new \DateTime();
        $newImage = ImageProcessor::PATH_UPLOAD . '/' . $this->getId() . '_' . $date->format('Ymd_His') . '.png';
        if (false === file_exists(ImageProcessor::PATH_UPLOAD)) {
            mkdir(ImageProcessor::PATH_UPLOAD);
        }
        copy($image, $newImage);

        try {
            /** @var Image $image */
            $image = ImageProcessor::get($newImage);
            $image = ImageProcessor::move($image, ImageProcessor::IMAGE_TYPE_KEY_ITEM, $this->getId());
            $this->picture = $image->getWebPath();

            return $this;
        } catch (\Exception $ex) {
            throw new \Exception(
                'Something unexpected happened in ' . basename($ex->getFile()) . '#' . $ex->getLine() . ': ' . $ex->getMessage(),
                0,
                $ex
            );

            return $this;
        }
    }

    public function getHistory() : ? string
    {
        return $this->history;
    }

    public function setHistory(string $history) : self
    {
        $this->history = trim($history);

        return $this;
    }

    public function getGeneralNotes() : ? string
    {
        return $this->generalNotes;
    }
}
