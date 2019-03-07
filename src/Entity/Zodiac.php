<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\ZodiacRepository")
 * @ORM\Table(name="zodiac_signs",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_zodiac_signs_name", columns={"name"}),
 *         @ORM\UniqueConstraint(name="unique_zodiac_signs_start", columns={"start"}),
 *         @ORM\UniqueConstraint(name="unique_zodiac_signs_end", columns={"end"}),
 *         @ORM\UniqueConstraint(name="unique_zodiac_signs_start_complementary", columns={"start_complementary"}),
 *         @ORM\UniqueConstraint(name="unique_zodiac_signs_end_complementary", columns={"end_complementary"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Zodiac
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
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;
    use DescriptionTrait;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(name="start", type="date", nullable=false, unique=true)
     * @Assert\NotNull(message="validator.not_blank")
     */
    protected $start;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(name="end", type="date", nullable=false, unique=true)
     * @Assert\NotNull(message="validator.not_blank")
     */
    protected $end;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(name="start_complementary", type="date", nullable=true, unique=true)
     */
    protected $startComplementary;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(name="end_complementary", type="date", nullable=true, unique=true)
     */
    protected $endComplementary;

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getStartComplementary(): ?\DateTimeInterface
    {
        return $this->startComplementary;
    }

    public function setStartComplementary(\DateTimeInterface $startComplementary): self
    {
        $this->startComplementary = $startComplementary;

        return $this;
    }

    public function getEndComplementary(): ?\DateTimeInterface
    {
        return $this->endComplementary;
    }

    public function setEndComplementary(\DateTimeInterface $endComplementary): self
    {
        $this->endComplementary = $endComplementary;

        return $this;
    }
}
