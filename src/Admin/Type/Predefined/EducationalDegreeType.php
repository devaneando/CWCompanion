<?php

namespace App\Admin\Type\Predefined;

use App\Entity\EducationalDegree;
use App\Admin\Type\Predefined\AbstractPredefinedType;

class EducationalDegreeType extends AbstractPredefinedType
{
    /** @var string $class */
    protected $class = EducationalDegree::class;

    /** @var string $class */
    protected $blockPrefix = 'educational_degree_type';
}
