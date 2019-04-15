<?php

namespace App\Security\Voter\Shared;

use App\Security\Voter\Shared\AbstractSharedVoter;
use App\Entity\IntelligenceQuotient;

class IntelligenceQuotientVoter extends AbstractSharedVoter
{
    protected $class = IntelligenceQuotient::class;
}
