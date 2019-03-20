<?php

namespace App\Entity;

use App\Entity\Chapter;
use App\Entity\Traits\DescriptionTrait;
use App\Exception\Parameter\InvalidAmbient;
use App\Exception\Parameter\InvalidTime;
use App\Traits\ConstantValidationTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\SceneRepository")
 * @ORM\Table(name="scenes")
 * @ORM\HasLifecycleCallbacks()
 */
class Scene
{
    const AMBIENT_EXTERIOR = 'EXT';
    const AMBIENT_INTERIOR = 'INT';
    const TIME_DAY = 'DAY';
    const TIME_NIGHT = 'NIGHT ';

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
     * @var Chapter
     * @ORM\ManyToOne(targetEntity="Chapter", inversedBy="scenes")
     * @ORM\JoinColumn(name="chapter_id", referencedColumnName="id")
     */
    private $chapter;

    /**
     * @var int
     * @ORM\Column(name="scene", type="integer", unique=false, nullable=false, options={"default":"0"})
     */
    protected $scene;

    /**
     * @var string
     * @ORM\Column(name="ambient", type="string", length=3, unique=false, nullable=false, options={"default":"INT"})
     * @Assert\NotNull(message="validator.not_blank")
     * @Assert\NotBlank(message="validator.not_blank")
     */
    protected $ambient;

    /**
     * @var string
     * @ORM\Column(name="time", type="string", length=5, unique=false, nullable=false, options={"default":"DAY"})
     * @Assert\NotNull(message="validator.not_blank")
     * @Assert\NotBlank(message="validator.not_blank")
     */
    protected $time;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;
    use DescriptionTrait;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = trim($description);

        return $this;
    }
}
