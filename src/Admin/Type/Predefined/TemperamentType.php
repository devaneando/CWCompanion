<?php

namespace App\Admin\Type\Predefined;

use App\Entity\Temperament;
use App\Admin\Type\Predefined\AbstractPredefinedType;

class TemperamentType extends AbstractPredefinedType
{
    /** @var string $class */
    protected $class = Temperament::class;

    /** @var string $class */
    protected $blockPrefix = 'temperament_type';
}
