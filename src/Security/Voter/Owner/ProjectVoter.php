<?php

namespace App\Security\Voter\Owner;

use App\Security\Voter\Owner\AbstractOwnerVoter;
use App\Entity\Project;

class ProjectVoter extends AbstractOwnerVoter
{
    protected $class = Project::class;
}
