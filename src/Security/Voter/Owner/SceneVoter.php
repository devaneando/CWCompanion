<?php

namespace App\Security\Voter\Owner;

use App\Security\Voter\Owner\AbstractOwnerVoter;
use App\Entity\Scene;

class SceneVoter extends AbstractOwnerVoter
{
    protected $class = Scene::class;
}
