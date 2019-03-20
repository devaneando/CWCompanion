<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\SceneRepository")
 * @ORM\Table(name="scenes",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_scenes_name", columns={"name"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Scene
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(name="id", type="uuid", unique=true)
     */
    protected $id;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }
}
