<?php

namespace App\Exception\Parameter;

class InvalidAmbient extends \Exception
{
    protected $message = 'The given ambient is invalid.';
}
