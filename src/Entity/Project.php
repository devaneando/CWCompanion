<?php

namespace App\Entity;

use App\Entity\Traits\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\ProjectRepository")
 * @ORM\Table(name="projects",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_projects_name", columns={"name"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Project
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(name="id", type="uuid", unique=true)
     */
    protected $id;

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

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=60, nullable=false)
     */
    protected $slug;
    use SlugTrait;

    /**
     * @var string
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    protected $picture;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }
}
