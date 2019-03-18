<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PredefinedTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\LocationTypeRepository")
 * @ORM\Table(
 *     name="location_types",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_location_types_name", columns={"name"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class LocationType
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
     * @var bool
     * @ORM\Column(name="predefined", type="boolean", nullable=true)
     */
    protected $predefined = false;
    use PredefinedTrait;
}
