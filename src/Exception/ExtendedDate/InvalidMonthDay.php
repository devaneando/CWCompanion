<?php

namespace App\Exception\ExtendedDate;

class InvalidMonthDay extends \Exception
{
    protected $message = 'The given month/day is invalid for the method scope or date.';
}
