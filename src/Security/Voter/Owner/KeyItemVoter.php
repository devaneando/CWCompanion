<?php

namespace App\Security\Voter\Owner;

use App\Security\Voter\Owner\AbstractOwnerVoter;
use App\Entity\KeyItem;

class KeyItemVoter extends AbstractOwnerVoter
{
    protected $class = KeyItem::class;
}
