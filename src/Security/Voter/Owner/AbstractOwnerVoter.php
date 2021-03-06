<?php

namespace App\Security\Voter\Owner;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

abstract class AbstractOwnerVoter extends Voter
{
    const DELETE = 'delete';
    const EDIT = 'edit';
    const PREVIEW = 'preview';
    const VIEW = 'view';

    protected $class;

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::DELETE, self::EDIT, self::VIEW, self::PREVIEW])) {
            return false;
        }

        if (null === $subject) {
            return false;
        }

        if (false === ($subject instanceof $this->class)) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        // the user must be logged in; if not, deny access
        if (false === ($user instanceof User)) {
            return false;
        }

        // If the object has no owner, writers or more can do anything with it
        if (null === $subject->getOwner()) {
            return $user->hasRole('ROLE_WRITER');
        }

        // Owners and moderators can view an object
        if (self::VIEW === $attribute || self::PREVIEW === $attribute) {
            return ($user === $subject->getOwner() || $user->hasRole('ROLE_MODERATOR'));
        }

        // Owners and moderators can edit and delete an object
        if (self::EDIT === $attribute || self::DELETE === $attribute) {
            return ($user === $subject->getOwner() || $user->hasRole('ROLE_MODERATOR'));
        }

        // If no other condition applies, the user has not access
        return false;
    }
}
