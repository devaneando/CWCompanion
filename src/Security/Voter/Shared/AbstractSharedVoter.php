<?php

namespace App\Security\Voter\Owner;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

abstract class AbstractSharedVoter extends Voter
{
    const DELETE = 'delete';
    const EDIT = 'edit';
    const PREVIEW = 'preview';
    const VIEW = 'view';

    protected $class;

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::DELETE, self::EDIT, self::VIEW, self::PREVIEW,])) {
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

        // The user must be logged in; if not, deny access
        if (false === ($user instanceof User)) {
            return false;
        }

        // Any logged user can view shared objects
        if (self::VIEW === $attribute || self::PREVIEW === $attribute) {
            return true;
        }

        // Only moderator or greater roles can edit or delete shared objects
        if (self::EDIT === $attribute || self::DELETE === $attribute) {
            return $user->hasRole('ROLE_WRITER');
        }

        // If no other condition applies, the user has not access
        return false;
    }
}
