<?php

namespace App\Security\Voter\Shared;

use App\Security\Voter\Shared\AbstractSharedVoter;
use App\Entity\Temperament;

class TemperamentVoter extends AbstractSharedVoter
{
    protected $class = Temperament::class;
}
