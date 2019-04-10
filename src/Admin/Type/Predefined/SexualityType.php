<?php

namespace App\Admin\Type\Predefined;

use App\Entity\Sexuality;
use App\Admin\Type\Predefined\AbstractPredefinedType;

class SexualityType extends AbstractPredefinedType
{
    /** @var string $class */
    protected $class = Sexuality::class;

    /** @var string $class */
    protected $blockPrefix = 'sexuality_type';
}
