<?php

namespace App\Exception\Image;

class InvalidHash extends \Exception
{
    protected $message = 'The given hash is invalid.';
}
