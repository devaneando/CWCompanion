<?php

namespace App\Security\Voter\Shared;

use App\Security\Voter\Shared\AbstractSharedVoter;
use App\Entity\Gender;

class GenderVoter extends AbstractSharedVoter
{
    protected $class = Gender::class;
}
