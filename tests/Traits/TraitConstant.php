<?php

namespace App\Tests\Traits;

use App\Traits\ConstantValidationTrait;

class TraitConstant
{
    const FORN_001 = 1000;
    const FORN_002 = 2000;
    const FORN_003 = 3000;
    const FORN_004 = 4000;
    const FORN_005 = 5000;

    use ConstantValidationTrait;

    public function getConstants()
    {
        return $this->getReflectionClassConstants();
    }

    public function getConstantKeys()
    {
        return $this->getReflectionClassConstantKeys();
    }

    public function isValid($constant, string $regex = '/^.*$/')
    {
        return $this->isValidConstant($constant, $regex);
    }
}
