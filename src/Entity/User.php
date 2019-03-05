<?php

namespace App\Entity;

use App\Entity\Group;
use App\Entity\Project;
use App\Entity\Traits\CreatedTrait;
use App\Entity\Traits\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
 *         @ORM\UniqueConstraint(name="unique_users_slug", columns={"slug"}),
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
     * @Assert\NotNull(message="validator.not_blank")
     * @Assert\NotBlank(message="validator.not_blank")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=120, unique=true)
     */
    protected $slug;
    use SlugTrait;

    public function getId(): ?int
    {
        return $this->id;
    }
}
