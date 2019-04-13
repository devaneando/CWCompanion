<?php

namespace App\Security\Voter\Owner;

use App\Security\Voter\Owner\AbstractOwnerVoter;
use App\Entity\Chapter;

class ChapterVoter extends AbstractOwnerVoter
{
    protected $class = Chapter::class;
}
