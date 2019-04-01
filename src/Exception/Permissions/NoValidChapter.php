<?php

namespace App\Exception\Permissions;

class NoValidChapter extends \Exception
{
    protected $message = "Can't create without a valid chapter.";
}
