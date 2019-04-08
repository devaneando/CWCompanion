<?php

namespace App\Admin\Type\OwnerAware;

use App\Admin\Type\OwnerAware\AbstractOnwerAwareType;
use App\Entity\Location;

class LocationType extends AbstractOnwerAwareType
{
    /** @var string $class */
    protected $class = Location::class;

    /** @var string $class */
    protected $blockPrefix = 'location';
}
