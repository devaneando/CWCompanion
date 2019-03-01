<?php

namespace App\Tests\Model;

use App\Exception\ExtendedDate\InvalidExtendedDateStamp;
use App\Exception\ExtendedDate\InvalidMonthDay;
use App\Exception\ExtendedDate\InvalidYear;
use App\Model\ExtendedDate;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExtendedDateTest extends WebTestCase
{
    public function testValidateExtendedDateStamp()
    {
        $this->expectException(InvalidExtendedDateStamp::class);
        ExtendedDate::validateExtendedDateStamp('2020-3-6');
        $this->assertNull(ExtendedDate::validateExtendedDateStamp('2020-12-23'));
        $this->assertNull(ExtendedDate::validateExtendedDateStamp('2020-12-23'));
    }

    public function testValidateYear()
    {
        $this->expectException(InvalidYear::class);
        ExtendedDate::validateYear('1.12');
        $this->assertNull(ExtendedDate::validateYear('2020'));
        $this->assertNull(ExtendedDate::validateYear('-2020'));
    }

    public function testvalidateMonthDay()
    {
        $this->expectException(InvalidMonthDay::class);
        ExtendedDate::validateMonthDay('13');
        $this->assertNull(ExtendedDate::validateMonthDay('12'));
        $this->expectException(InvalidMonthDay::class);
        ExtendedDate::validateMonthDay('12', '45');
        $this->assertNull(ExtendedDate::validateMonthDay('12', '31'));
    }

    public function testExtendedDateStampToArray()
    {
        $result = ['anno_domini' => true, 'year' => 2020, 'month' => 12, 'day' => 31];
        $this->assertEquals($result, ExtendedDate::extendedDateStampToArray('2020-12-31'));
        $result = ['anno_domini' => false, 'year' => 2020, 'month' => 12, 'day' => 31];
        $this->assertEquals($result, ExtendedDate::extendedDateStampToArray('-2020-12-31'));

        $result = ['anno_domini' => true, 'year' => 900, 'month' => 12, 'day' => 31];
        $this->assertEquals($result, ExtendedDate::extendedDateStampToArray('900-12-31'));
        $result = ['anno_domini' => false, 'year' => 900, 'month' => 12, 'day' => 31];
        $this->assertEquals($result, ExtendedDate::extendedDateStampToArray('-900-12-31'));

        $result = ['anno_domini' => true, 'year' => 9, 'month' => 12, 'day' => 31];
        $this->assertEquals($result, ExtendedDate::extendedDateStampToArray('09-12-31'));
        $result = ['anno_domini' => false, 'year' => 9, 'month' => 12, 'day' => 31];
        $this->assertEquals($result, ExtendedDate::extendedDateStampToArray('-09-12-31'));
    }

    public function testDateTimeToExtendedDate()
    {
        $date = \DateTime::createFromFormat('Y-m-d', '2020-12-31');
        $extendedDate = new ExtendedDate('2020-12-31');
        $this->assertEquals($extendedDate, ExtendedDate::dateTimeToExtendedDate($date));
    }

    public function testSortExtendedDates()
    {
        $extendedDate01 = new ExtendedDate('2020-12-31');
        $extendedDate02 = new ExtendedDate('2040-12-31');
        $extendedDate03 = new ExtendedDate('10-12-31');
        $extendedDate04 = new ExtendedDate('900-12-31');
        $extendedDate05 = new ExtendedDate('-100-12-31');
        $extendedDate06 = new ExtendedDate('-10-12-31');
        $dates = ExtendedDate::sortExtendedDates($extendedDate01, $extendedDate02, $extendedDate03, $extendedDate04, $extendedDate05, $extendedDate06);
        /** @var ExtendedDate $theDate */
        $theDate = $dates[5];
        $this->assertEquals('2040-12-31', $theDate->date());
        $theDate = $dates[0];
        $this->assertEquals('-10-12-31', $theDate->date());
        $theDate = $dates[2];
        $this->assertEquals('10-12-31', $theDate->date());
    }

    public function testYear()
    {
        $extendedDate = new ExtendedDate('2020-12-31');
        $this->assertTrue($extendedDate->isAnnoDomini());
        $this->assertEmpty($extendedDate->annoDominiAsString());
        $this->assertEquals(2020, $extendedDate->getYear());
        $this->assertEquals('2020', $extendedDate->yearAsString());
        $extendedDate = new ExtendedDate('-09-02-29');
        $this->assertFalse($extendedDate->isAnnoDomini());
        $this->assertEquals('-', $extendedDate->annoDominiAsString());
        $this->assertEquals(9, $extendedDate->getYear());
        $this->assertEquals('-9', $extendedDate->yearAsString());
    }

    public function testMonth()
    {
        $extendedDate = new ExtendedDate('2020-02-29');
        $this->assertEquals(2, $extendedDate->getMonth());
        $this->assertEquals('02', $extendedDate->monthAsString());
    }

    public function testDay()
    {
        $extendedDate = new ExtendedDate('2020-02-08');
        $this->assertEquals(8, $extendedDate->getDay());
        $this->assertEquals('08', $extendedDate->dayAsString());
    }

    public function testFirstDay()
    {
        $extendedDate = new ExtendedDate('2020-02-08');
        $extendedDate->setFirstDay();
        $this->assertEquals(1, $extendedDate->getMonth());
        $this->assertEquals(1, $extendedDate->getDay());
    }

    public function testLastDay()
    {
        $extendedDate = new ExtendedDate('2020-02-08');
        $extendedDate->setLastDay();
        $this->assertEquals(12, $extendedDate->getMonth());
        $this->assertEquals(31, $extendedDate->getDay());
    }

    public function testDate()
    {
        $extendedDate = new ExtendedDate('2020-02-08');
        $this->assertEquals('2020-02-08', $extendedDate->date());
        $this->assertEquals(20200208, $extendedDate->dateAsInteger());
        $date = [
            'anno_domini' => 1,
            'year' => 2020,
            'month' => 2,
            'day' => 8,

        ];
        $this->assertEquals($date, $extendedDate->dateAsArray());
    }

    public function testIsBefore()
    {
        $date = new ExtendedDate('2020-02-08');
        $equal = new ExtendedDate('2020-02-08');
        $after = new ExtendedDate('2020-02-09');
        $before = new ExtendedDate('2020-02-07');
        $this->assertTrue($date->isBefore($after));
        $this->assertFalse($date->isBefore($equal));
        $this->assertFalse($date->isBefore($before));
        $this->assertTrue($date->isBeforeEqual($after));
        $this->assertTrue($date->isBeforeEqual($equal));
        $this->assertFalse($date->isBeforeEqual($before));

        $equal = \DateTime::createFromFormat('Y-m-d', '2020-02-08');
        $after = \DateTime::createFromFormat('Y-m-d', '2020-02-09');
        $before = \DateTime::createFromFormat('Y-m-d', '2020-02-07');
        $this->assertTrue($date->isBeforeDate($after));
        $this->assertFalse($date->isBeforeDate($equal));
        $this->assertFalse($date->isBeforeDate($before));
        $this->assertTrue($date->isBeforeEqualDate($after));
        $this->assertTrue($date->isBeforeEqualDate($equal));
        $this->assertFalse($date->isBeforeEqualDate($before));
    }

    public function testIsAfter()
    {
        $date = new ExtendedDate('2020-02-08');
        $equal = new ExtendedDate('2020-02-08');
        $after = new ExtendedDate('2020-02-09');
        $before = new ExtendedDate('2020-02-07');
        $this->assertTrue($date->isAfter($before));
        $this->assertFalse($date->isAfter($equal));
        $this->assertFalse($date->isAfter($after));
        $this->assertTrue($date->isAfterEqual($before));
        $this->assertTrue($date->isAfterEqual($equal));
        $this->assertFalse($date->isAfterEqual($after));

        $equal = \DateTime::createFromFormat('Y-m-d', '2020-02-08');
        $after = \DateTime::createFromFormat('Y-m-d', '2020-02-09');
        $before = \DateTime::createFromFormat('Y-m-d', '2020-02-07');
        $this->assertTrue($date->isAfterDate($before));
        $this->assertFalse($date->isAfterDate($equal));
        $this->assertFalse($date->isAfterDate($after));
        $this->assertTrue($date->isAfterEqualDate($before));
        $this->assertTrue($date->isAfterEqualDate($equal));
        $this->assertFalse($date->isAfterEqualDate($after));
    }

    public function testIsEqual()
    {
        $date = new ExtendedDate('2020-02-08');
        $equal = new ExtendedDate('2020-02-08');
        $after = new ExtendedDate('2020-02-09');
        $this->assertTrue($date->isEqual($equal));
        $this->assertFalse($date->isEqual($after));

        $equal = \DateTime::createFromFormat('Y-m-d', '2020-02-08');
        $after = \DateTime::createFromFormat('Y-m-d', '2020-02-09');
        $this->assertTrue($date->isEqualDate($equal));
        $this->assertFalse($date->isEqualDate($after));
    }

    public function testIsBetween()
    {
        $date = new ExtendedDate('2020-02-08');
        $before = new ExtendedDate('2020-02-07');
        $after = new ExtendedDate('2020-02-09');
        $this->assertTrue($date->isBetween($before, $after));
    }
}
