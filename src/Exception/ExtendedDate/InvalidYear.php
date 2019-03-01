<?php

namespace App\Exception\ExtendedDate;

class InvalidYear extends \Exception
{
    protected $message = 'The given year is invalid for the method scope or date.';
}
