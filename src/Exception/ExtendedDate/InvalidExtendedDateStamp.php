<?php

namespace App\Exception\ExtendedDate;

class InvalidExtendedDateStamp extends \Exception
{
    protected $message = 'The given ExtendedDate stamp is invalid. Do the month and the day have two digits?';
}
