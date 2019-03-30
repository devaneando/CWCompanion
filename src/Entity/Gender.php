<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PredefinedTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\GenderRepository")
 * @ORM\Table(name="genders",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_genders_name", columns={"name"}),
 *         @ORM\UniqueConstraint(name="unique_genders_code", columns={"code"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Gender
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;
    use IdTrait;

    /**
     * @var string
     * @ORM\Column(name="code", type="string", length=1, unique=true)
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     * @Assert\Length(
     *     max = 1,
     *     maxMessage="length.max.gender.code"
     * )
     */
    protected $code;

    /**
     * @var string
     * @ORM\Column(name="icon", type="string", length=60, unique=false)
     * @Assert\Length(
     *     max = 60,
     *     maxMessage="length.max.gender.icon"
     * )
     */
    protected $icon;

    /**
     * @ORM\Column(name="name", type="string", length=120, unique=true)
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     * @Assert\Length(
     *     max = 120,
     *     maxMessage="length.max.gender.name"
     * )
     */
    protected $name;
    use NameTrait;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;
    use DescriptionTrait;

    /**
     * @var bool
     * @ORM\Column(name="predefined", type="boolean", nullable=true)
     */
    protected $predefined = false;
    use PredefinedTrait;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = trim($code);

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = trim($icon);

        return $this;
    }
}
