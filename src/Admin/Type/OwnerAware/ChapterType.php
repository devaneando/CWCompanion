<?php

namespace App\Admin\Type\OwnerAware;

use App\Admin\Type\OwnerAware\AbstractOnwerAwareType;
use App\Entity\Chapter;

class ChapterType extends AbstractOnwerAwareType
{
    /** @var string $class */
    protected $class = Chapter::class;

    /** @var string $class */
    protected $blockPrefix = 'chapter_type';
}
