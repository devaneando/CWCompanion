<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PredefinedTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\ProfessionRepository")
 * @ORM\Table(name="professions",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_professions_name", columns={"name"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Profession
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
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     * @Assert\Length(
     *     max = 120,
     *     maxMessage="length.max.profession.name"
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
