<?php

namespace App\Admin\Type\Predefined;

use App\Entity\LocationType as EntityLocationType;
use App\Admin\Type\Predefined\AbstractPredefinedType;

class LocationType extends AbstractPredefinedType
{
    /** @var string $class */
    protected $class = EntityLocationType::class;

    /** @var string $class */
    protected $blockPrefix = 'location_type';
}
