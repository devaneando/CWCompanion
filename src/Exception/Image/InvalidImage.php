<?php

namespace App\Exception\Image;

class InvalidImage extends \Exception
{
    protected $message = 'The given image is invalid.';
}
