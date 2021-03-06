<?php

namespace App\Admin\Type\OwnerAware;

use App\Admin\Type\OwnerAware\AbstractOnwerAwareType;
use App\Entity\Concept;

class ConceptType extends AbstractOnwerAwareType
{
    /** @var string $class */
    protected $class = Concept::class;

    /** @var string $class */
    protected $blockPrefix = 'concept_type';
}
