<?php

namespace App\Admin\Type\Predefined;

use App\Entity\Zodiac;
use App\Admin\Type\Predefined\AbstractPredefinedType;

class ZodiacType extends AbstractPredefinedType
{
    /** @var string $class */
    protected $class = Zodiac::class;

    /** @var string $class */
    protected $blockPrefix = 'zodiac_type';
}
