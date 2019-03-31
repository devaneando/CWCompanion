<?php

namespace App\Exception\Permissions;

class NoValidProject extends \Exception
{
    protected $message = "Can't create without a valid project.";
}
