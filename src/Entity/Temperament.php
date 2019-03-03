<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\TemperamentRepository")
 * @ORM\Table(name="temperaments",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_temperaments_name", columns={"name"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Temperament
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
     */
    protected $name;
    use NameTrait;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;
    use DescriptionTrait;
}
