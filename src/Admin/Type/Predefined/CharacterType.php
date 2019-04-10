<?php

namespace App\Admin\Type\Predefined;

use App\Entity\CharacterType as EntityCharacterType;
use App\Admin\Type\Predefined\AbstractPredefinedType;

class CharacterType extends AbstractPredefinedType
{
    /** @var string $class */
    protected $class = EntityCharacterType::class;

    /** @var string $class */
    protected $blockPrefix = 'character_type';
}
