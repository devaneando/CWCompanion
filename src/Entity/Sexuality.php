<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\SexualityRepository")
 * @ORM\Table(name="sexualities",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_sexualities_name", columns={"name"}),
 *         @ORM\UniqueConstraint(name="unique_sexualities_predefined", columns={"predefined"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Sexuality
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
     * @ORM\Column(name="predefined", type="boolean", nullable=true, unique=true)
     */
    protected $predefined;

    public function getPredefined()
    {
        return $this->predefined;
    }

    public function setPredefined($predefined): self
    {
        $this->predefined = $predefined;

        return $this;
    }
}
