<?php

namespace App\Admin\Type\Predefined;

use App\Entity\Gender;
use App\Admin\Type\Predefined\AbstractPredefinedType;

class GenderType extends AbstractPredefinedType
{
    /** @var string $class */
    protected $class = Gender::class;

    /** @var string $class */
    protected $blockPrefix = 'gender_type';
}
