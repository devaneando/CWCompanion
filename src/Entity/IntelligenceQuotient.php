<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PredefinedTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\IntelligenceQuotientRepository")
 * @ORM\Table(name="intelligence_quotients",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_intelligence_quotients_name", columns={"name"}),
 *         @ORM\UniqueConstraint(name="unique_intelligence_quotients_minimum", columns={"minimum"}),
 *         @ORM\UniqueConstraint(name="unique_intelligence_quotients_maximum", columns={"maximum"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class IntelligenceQuotient
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
     * @var int
     * @Assert\NotNull(message="validator.not_blank")
     * @Assert\NotBlank(message="validator.not_blank")
     * @ORM\Column(name="minimum", type="integer", nullable=false, unique=true)
     */
    protected $minimum;

    /**
     * @var int
     * @Assert\NotNull(message="validator.not_blank")
     * @Assert\NotBlank(message="validator.not_blank")
     * @ORM\Column(name="maximum", type="integer", nullable=false, unique=true)
     */
    protected $maximum;

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

    public function getMinimum(): ?int
    {
        return $this->minimum;
    }

    public function setMinimum(int $minimum): self
    {
        $this->minimum = $minimum;

        return $this;
    }

    public function getMaximum(): ?int
    {
        return $this->maximum;
    }

    public function setMaximum(int $maximum): self
    {
        $this->maximum = $maximum;

        return $this;
    }
}
