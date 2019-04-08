<?php

namespace App\Admin\Type\OwnerAware;

use App\Admin\Type\OwnerAware\AbstractOnwerAwareType;
use App\Entity\Project;

class ProjectType extends AbstractOnwerAwareType
{
    /** @var string $class */
    protected $class = Project::class;

    /** @var string $class */
    protected $blockPrefix = 'project';
}
