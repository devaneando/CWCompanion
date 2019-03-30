<?php

namespace App\Traits;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

trait LoggedUserTrait
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var User */
    private $loggedUser;

    /** @return TokenStorageInterface */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    /**
     * @param TokenStorageInterface $tokenStorage
     *
     * @return self
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function setLoggedUser()
    {
        $this->loggedUser = $this->getTokenStorage()->getToken()->getUser();
    }

    /** @return User */
    public function getLoggedUser()
    {
        if (null === $this->loggedUser) {
            $this->setLoggedUser();
        }

        return $this->loggedUser;
    }
}
