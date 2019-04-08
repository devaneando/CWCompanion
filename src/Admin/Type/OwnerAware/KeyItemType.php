<?php

namespace App\Admin\Type\OwnerAware;

use App\Admin\Type\OwnerAware\AbstractOnwerAwareType;
use App\Entity\KeyItem;

class KeyItemType extends AbstractOnwerAwareType
{
    /** @var string $class */
    protected $class = KeyItem::class;

    /** @var string $class */
    protected $blockPrefix = 'key_item';
}
