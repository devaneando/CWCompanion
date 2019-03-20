<?php

namespace App\Tests\Traits;

use App\Tests\Traits\TraitConstant;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConstantValidationTraitTest extends WebTestCase
{
    public function testGetConstants()
    {
        $traitConstant = new TraitConstant();
        $constants = $traitConstant->getConstants();
        $this->assertCount(5, $constants);
        $keys = $traitConstant->getConstantKeys();
        $this->assertEquals(['FORN_001', 'FORN_002', 'FORN_003', 'FORN_004', 'FORN_005'], $keys);
        $this->assertFalse($traitConstant->isValid('9000'));
        $this->assertFalse($traitConstant->isValid('1000', '/^DOB.*$/'));
        $this->assertTrue($traitConstant->isValid('1000'));
    }
}
