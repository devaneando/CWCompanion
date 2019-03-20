<?php

namespace App\Exception\Parameter;

class InvalidTime extends \Exception
{
    protected $message = 'The given time is invalid.';
}
