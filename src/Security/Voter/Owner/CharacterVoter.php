<?php

namespace App\Security\Voter\Owner;

use App\Security\Voter\Owner\AbstractOwnerVoter;
use App\Entity\Character;

class CharacterVoter extends AbstractOwnerVoter
{
    protected $class = Character::class;
}
