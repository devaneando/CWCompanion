<?php

namespace App\Admin\Type\Predefined;

use App\Entity\Country;
use App\Admin\Type\Predefined\AbstractPredefinedType;

class CountryType extends AbstractPredefinedType
{
    /** @var string $class */
    protected $class = Country::class;

    /** @var string $class */
    protected $blockPrefix = 'country_type';
}
