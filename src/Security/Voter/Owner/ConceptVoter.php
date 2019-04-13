<?php

namespace App\Security\Voter\Owner;

use App\Security\Voter\Owner\AbstractOwnerVoter;
use App\Entity\Concept;

class ConceptVoter extends AbstractOwnerVoter
{
    protected $class = Concept::class;
}
