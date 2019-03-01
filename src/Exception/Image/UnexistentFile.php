<?php

namespace App\Exception\Image;

class UnexistentFile extends \Exception
{
    protected $message = 'The given file does not exist.';
}
