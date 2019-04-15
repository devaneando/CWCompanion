<?php

namespace App\Security\Voter\Shared;

use App\Security\Voter\Shared\AbstractSharedVoter;
use App\Entity\Religion;

class ReligionVoter extends AbstractSharedVoter
{
    protected $class = Religion::class;
}
