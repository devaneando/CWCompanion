<?php

namespace App\Security\Voter\Shared;

use App\Security\Voter\Shared\AbstractSharedVoter;
use App\Entity\EducationalDegree;

class EducationalDegreeVoter extends AbstractSharedVoter
{
    protected $class = EducationalDegree::class;
}
