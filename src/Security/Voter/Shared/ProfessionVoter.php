<?php

namespace App\Security\Voter\Shared;

use App\Security\Voter\Shared\AbstractSharedVoter;
use App\Entity\Profession;

class ProfessionVoter extends AbstractSharedVoter
{
    protected $class = Profession::class;
}
