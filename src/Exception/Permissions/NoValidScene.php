<?php

namespace App\Exception\Permissions;

class NoValidScene extends \Exception
{
    protected $message = "Can't create without a valid scene.";
}
