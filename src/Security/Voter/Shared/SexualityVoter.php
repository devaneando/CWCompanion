<?php

namespace App\Security\Voter\Shared;

use App\Security\Voter\Shared\AbstractSharedVoter;
use App\Entity\Sexuality;

class SexualityVoter extends AbstractSharedVoter
{
    protected $class = Sexuality::class;
}
