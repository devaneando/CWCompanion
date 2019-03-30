<?php

namespace App\Entity;

use App\Entity\Project;
use App\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\UserRepository")
 * @ORM\Table(name="users",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="unique_users_confirmation_token", columns={"confirmation_token"}),
 *         @ORM\UniqueConstraint(name="unique_users_email_canonical", columns={"email_canonical"}),
 *         @ORM\UniqueConstraint(name="unique_users_name", columns={"name"}),
 *         @ORM\UniqueConstraint(name="unique_users_username_canonical", columns={"username_canonical"}),
 *     }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=120, unique=true)
     * @Assert\NotNull(message="not_null.default")
     * @Assert\NotNull(message="not_blank.default")
     */
    protected $name;
    use NameTrait;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Project", mappedBy="owner")
     */
    protected $projects;

    public function getId(): ?int
    {
        return $this->id;
    }

    /** @return ArrayCollection|PersistentCollection */
    public function getProjects()
    {
        return $this->projects;
    }

    /** @param ArrayCollection|PersistentCollection|null $projects */
    public function setProjects($projects): self
    {
        $this->projects = $projects;

        return $this;
    }

    public function addProject(Project $object): self
    {
        if (true === $this->projects->contains($object)) {
            return $this;
        }
        $this->projects->add($object);
        $object->setOwner($this);

        return $this;
    }
}
