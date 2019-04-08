<?php

namespace App\Admin\Type\OwnerAware;

use App\Admin\Type\OwnerAware\AbstractOnwerAwareType;
use App\Entity\Character;

class CharacterType extends AbstractOnwerAwareType
{
    /** @var string $class */
    protected $class = Character::class;

    /** @var string $class */
    protected $blockPrefix = 'character';
}
