<?php

namespace App\Security\Voter\Shared;

use App\Security\Voter\Shared\AbstractSharedVoter;
use App\Entity\CharacterType;

class CharacterTypeVoter extends AbstractSharedVoter
{
    protected $class = CharacterType::class;
}
