<?php

namespace App\Security\Voter\Owner;

use App\Security\Voter\Owner\AbstractOwnerVoter;
use App\Entity\Location;

class LocationVoter extends AbstractOwnerVoter
{
    protected $class = Location::class;
}
