<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PredefinedTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\CountryRepository")
 * @ORM\Table(name="countries",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_countries_name", columns={"name"}),
 *         @ORM\UniqueConstraint(name="unique_countries_code", columns={"code"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Country
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
     * @ORM\Column(name="code", type="string", length=10, unique=true)
     * @Assert\NotNull(message="validator.not_blank")
     * @Assert\NotBlank(message="validator.not_blank")
     * @Assert\Length(
     *     max = 10,
     *     maxMessage="validator.length_max.code"
     * )
     */
    protected $code;

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
