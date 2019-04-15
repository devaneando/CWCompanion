<?php

namespace App\Security\Voter\Shared;

use App\Security\Voter\Shared\AbstractSharedVoter;
use App\Entity\LocationType;

class LocationTypeVoter extends AbstractSharedVoter
{
    protected $class = LocationType::class;
}
