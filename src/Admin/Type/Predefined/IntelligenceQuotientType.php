<?php

namespace App\Admin\Type\Predefined;

use App\Entity\IntelligenceQuotient;
use App\Admin\Type\Predefined\AbstractPredefinedType;

class IntelligenceQuotientType extends AbstractPredefinedType
{
    /** @var string $class */
    protected $class = IntelligenceQuotient::class;

    /** @var string $class */
    protected $blockPrefix = 'intelligence_quotient_type';
}
