<?php

namespace App\Admin\Type\OwnerAware;

use App\Admin\Type\OwnerAware\AbstractOnwerAwareType;
use App\Entity\Scene;

class SceneType extends AbstractOnwerAwareType
{
    /** @var string $class */
    protected $class = Scene::class;

    /** @var string $class */
    protected $blockPrefix = 'scene';
}
