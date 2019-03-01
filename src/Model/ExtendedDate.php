<?php

namespace App\Model;

use App\Exception\ExtendedDate\InvalidExtendedDateStamp;
use App\Exception\ExtendedDate\InvalidMonthDay;
use App\Exception\ExtendedDate\InvalidYear;

class ExtendedDate
{
    const DEFAULT_YEAR = 2020;
    const DEFAULT_MONTH = 12;
    const DEFAULT_DAY = 23;
    const REGEX_EXTENDED_DATE_STAMP = '/^[-+]?[0-9]+-{1}[0-9]{2}-{1}[0-9]{2}?$/';

    /** @var bool */
    protected $annoDomini = true;

    /** @var int */
    protected $year;

    /** @var int */
    protected $month;

    /** @var int */
    protected $day;

    /**
     * Validates a string to make sure it matches the self::REGEX_EXTENDED_DATE_STAMP pattern.
     *
     * @param string $extendedDateStamp the ExtendedDate timestamp.
     *               The year must be an integer, preceded by a (-)minus sign to represent years before Christ.
     *               The month and the the day must be represented by two digits each
     *
     * @example Alexander, The Great's death '-323-06-11'
     *
     * @throws InvalidExtendedDateStamp
     */
    public static function validateExtendedDateStamp(string $extendedDateStamp)
    {
        if (false == preg_match(self::REGEX_EXTENDED_DATE_STAMP, $extendedDateStamp)) {
            throw new InvalidExtendedDateStamp("The given stamp [${extendedDateStamp}] is invalid.");
        }
    }

    /** @throws InvalidYear */
    public static function validateYear(string $year)
    {
        if (false === filter_var($year, FILTER_VALIDATE_INT)) {
            throw new InvalidYear();
        }
    }

    /** @throws InvalidMonthDay */
    public static function validateMonthDay($month = self::DEFAULT_MONTH, $day = self::DEFAULT_DAY)
    {
        if (false === checkdate((int)$month, (int)$day, self::DEFAULT_YEAR)) {
            throw new InvalidMonthDay();
        }
    }

    /**
     * Convert an ExtendedDateStamp to an array.
     *
     * @param string $extendedDateStamp A timestamp in the REGEX_EXTENDED_DATE_STAMP format
     *
     * @throws InvalidExtendedDateStamp
     * @throws InvalidYear
     * @throws InvalidMonthDay
     *
     * @return array
     */
    public static function extendedDateStampToArray(string $extendedDateStamp): array
    {
        self::validateExtendedDateStamp($extendedDateStamp);

        $result = ['anno_domini' => true];
        if (0 === strpos($extendedDateStamp, '-') || 0 === strpos($extendedDateStamp, '+')) {
            $result['anno_domini'] = ('+' === $extendedDateStamp[0]) ? true : false;
            $extendedDateStamp = substr($extendedDateStamp, 1, strlen($extendedDateStamp));
        }

        $dateStamp = explode('-', $extendedDateStamp);

        self::validateYear(ltrim($dateStamp[0], '0'));
        $result['year'] = (int)$dateStamp[0];
        $month = $dateStamp[1];
        $day = $dateStamp[2];
        self::validateMonthDay($month, $day);
        $result['month'] = (int)$month;
        $result['day'] = (int)$day;

        return $result;
    }

    public static function dateTimeToExtendedDate(\DateTime $dateTime): self
    {
        $extendedDate = new self();
        $extendedDate
            ->setAnnoDomini(true)
            ->setYear((int)$dateTime->format('Y'))
            ->setMonth((int)$dateTime->format('m'))
            ->setDay((int)$dateTime->format('d'));

        return $extendedDate;
    }

    public static function sortExtendedDates(self ...$extendedDates): ?array
    {
        $toSort = [];
        foreach ($extendedDates as $extendedDate) {
            $toSort[$extendedDate->dateAsInteger()] = $extendedDate;
        }
        asort($toSort, SORT_ASC);

        return array_values($toSort);
    }

    /**
     * @throws InvalidExtendedDateStamp
     */
    public function __construct(string $extendedDateStamp = null)
    {
        $date = new \DateTime();
        $dateArray = [
            'anno_domini' => true,
            'year' => (int)$date->format('Y'),
            'month' => (int)$date->format('m'),
            'day' => (int)$date->format('d'),
        ];

        if (null !== $extendedDateStamp) {
            self::validateExtendedDateStamp($extendedDateStamp);
            $dateArray = self::extendedDateStampToArray($extendedDateStamp);
        }

        try {
            $this
                ->setAnnoDomini($dateArray['anno_domini'])
                ->setYear($dateArray['year'])
                ->setMonth($dateArray['month'])
                ->setDay($dateArray['day']);
        } catch (\Exception $ex) {
            throw new InvalidExtendedDateStamp('The given extended date stamp was invalid in the constructor context.');
        }
    }

    public function isAnnoDomini(): bool
    {
        return $this->annoDomini;
    }

    public function annoDominiAsString(): ?string
    {
        return (false === $this->annoDomini) ? '-' : '';
    }

    public function setAnnoDomini(bool $annoDomini): self
    {
        $this->annoDomini = $annoDomini;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function yearAsString(): ?string
    {
        return (null === $this->year) ? '' : $this->annoDominiAsString().$this->year;
    }

    public function setYear(int $year): self
    {
        if (0 > $year) {
            $this->annoDomini = false;
        }
        $this->year = abs($year);

        return $this;
    }

    /** Sets the date to 01 January. */
    public function setFirstDay()
    {
        $this
            ->setMonth(1)
            ->setDay(1);
    }

    /** Sets the date to 31 December. */
    public function setLastDay()
    {
        $this
            ->setMonth(12)
            ->setDay(31);
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function monthAsString(): ?string
    {
        return (null === $this->month) ? null : sprintf('%02d', $this->month);
    }

    /** @throws InvalidMonthDay */
    public function setMonth(int $month): self
    {
        $this->validateMonthDay($month);
        $this->month = $month;

        return $this;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function dayAsString(): ?string
    {
        return (null === $this->day) ? null : sprintf('%02d', $this->day);
    }

    /** @throws InvalidMonthDay */
    public function setDay(int $day): self
    {
        $this->validateMonthDay(self::DEFAULT_MONTH, $day);
        $this->day = $day;

        return $this;
    }

    public function date(): ?string
    {
        if (null === $this->year || null === $this->month || null === $this->day) {
            return null;
        }

        return $this->yearAsString().'-'.$this->monthAsString().'-'.$this->dayAsString();
    }

    public function dateAsInteger(): ?int
    {
        return (int)($this->yearAsString().$this->monthAsString().$this->dayAsString());
    }

    public function dateAsArray(): ?array
    {
        if (null === $this->date()) {
            return null;
        }

        return [
            'anno_domini' => $this->isAnnoDomini(),
            'year' => $this->getYear(),
            'month' => $this->getMonth(),
            'day' => $this->getDay(),
        ];
    }

    public function __toString(): string
    {
        return (null === $this->date()) ? '' : $this->date();
    }

    public function isBefore(self $extendedDate): bool
    {
        if (null === $this->dateAsInteger() || null === $extendedDate->dateAsInteger()) {
            return false;
        }

        return $this->dateAsInteger() < $extendedDate->dateAsInteger();
    }

    public function isBeforeEqual(self $extendedDate): bool
    {
        if (null === $this->dateAsInteger() || null === $extendedDate->dateAsInteger()) {
            return false;
        }

        return $this->dateAsInteger() <= $extendedDate->dateAsInteger();
    }

    public function isBeforeDate(\DateTime $dateTime): bool
    {
        return $this->isBefore(self::dateTimeToExtendedDate($dateTime));
    }

    public function isBeforeEqualDate(\DateTime $dateTime): bool
    {
        return $this->isBeforeEqual(self::dateTimeToExtendedDate($dateTime));
    }

    public function isAfter(self $extendedDate): bool
    {
        if (null === $this->dateAsInteger() || null === $extendedDate->dateAsInteger()) {
            return false;
        }

        return $this->dateAsInteger() > $extendedDate->dateAsInteger();
    }

    public function isAfterEqual(self $extendedDate): bool
    {
        if (null === $this->dateAsInteger() || null === $extendedDate->dateAsInteger()) {
            return false;
        }

        return $this->dateAsInteger() >= $extendedDate->dateAsInteger();
    }

    public function isAfterDate(\DateTime $dateTime): bool
    {
        return $this->isAfter(self::dateTimeToExtendedDate($dateTime));
    }

    public function isAfterEqualDate(\DateTime $dateTime): bool
    {
        return $this->isAfterEqual(self::dateTimeToExtendedDate($dateTime));
    }

    public function isEqual(self $extendedDate): bool
    {
        return $this->dateAsInteger() === $extendedDate->dateAsInteger();
    }

    public function isEqualDate(\DateTime $dateTime): bool
    {
        return $this->isEqual(self::dateTimeToExtendedDate($dateTime));
    }

    public function isBetween(self $extendedDate01, self $extendedDate02): ?bool
    {
        $sorted = self::sortExtendedDates($extendedDate01, $extendedDate02);
        if (false === $this->isAfterEqual($sorted[0]) && false === $this->isBeforeEqual($sorted[1])) {
            return false;
        }

        return true;
    }
}
