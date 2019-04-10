<?php

namespace App\Admin\Type\Predefined;

use App\Entity\Profession;
use App\Admin\Type\Predefined\AbstractPredefinedType;

class ProfessionType extends AbstractPredefinedType
{
    /** @var string $class */
    protected $class = Profession::class;

    /** @var string $class */
    protected $blockPrefix = 'profession_type';
}
