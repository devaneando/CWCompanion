<?php

namespace App\Security\Voter\Shared;

use App\Security\Voter\Shared\AbstractSharedVoter;
use App\Entity\Zodiac;

class ZodiacVoter extends AbstractSharedVoter
{
    protected $class = Zodiac::class;
}
