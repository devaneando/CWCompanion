<?php

namespace App\Security\Voter\Shared;

use App\Security\Voter\Shared\AbstractSharedVoter;
use App\Entity\Country;

class CountryVoter extends AbstractSharedVoter
{
    protected $class = Country::class;
}
