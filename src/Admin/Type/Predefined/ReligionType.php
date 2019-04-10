<?php

namespace App\Admin\Type\Predefined;

use App\Entity\Religion;
use App\Admin\Type\Predefined\AbstractPredefinedType;

class ReligionType extends AbstractPredefinedType
{
    /** @var string $class */
    protected $class = Religion::class;

    /** @var string $class */
    protected $blockPrefix = 'religion_type';
}
