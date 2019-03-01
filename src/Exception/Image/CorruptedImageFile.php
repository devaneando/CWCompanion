<?php

namespace App\Exception\Image;

class CorruptedImageFile extends \Exception
{
    protected $message = 'The given image is corrupted.';
}
