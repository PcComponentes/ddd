<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class DateTimeValueObject extends \DateTimeImmutable implements ValueObject
{
    private const TIME_ZONE = 'UTC';
    private const TIME_FORMAT = 'Y-m-d\TH:i:s.uP';
    private const FORMAT = \DATE_ATOM;

    final private function __construct($time, $timezone)
    {
        parent::__construct($time, $timezone);
    }

    public static function from(string $str): static
    {
        $timeZone = new \DateTimeZone(self::TIME_ZONE);

        return (new static($str, $timeZone))->setTimezone($timeZone);
    }

    final public static function now(): static
    {
        return static::from('now');
    }

    final public static function createFromMutable(\DateTime $object): static
    {
        return static::from($object->format(self::TIME_FORMAT));
    }

    final public static function createFromInterface(\DateTimeInterface $object): static
    {
        return static::from($object->format(self::TIME_FORMAT));
    }

    final public static function createFromFormat(
        string $format,
        string $datetime,
        ?\DateTimeZone $timezone = null
    ): static | false {
        $datetime = parent::createFromFormat($format, $datetime, $timezone);

        if (false === $datetime) {
            return false;
        }

        $timeZone = new \DateTimeZone(self::TIME_ZONE);

        return static::createFromInterface($datetime->setTimezone($timeZone));
    }

    final public static function fromFormat(string $format, string $str): static | false
    {
        return static::createFromFormat($format, $str, new \DateTimeZone(self::TIME_ZONE));
    }

    final public static function createFromTimestamp(float|int $timestamp): static
    {
        $dateTime = \is_int($timestamp)
            ? self::fromFormat('U', (string) $timestamp)
            : self::fromFormat('U.u', \number_format($timestamp, 6, '.', ''));

        \assert(false !== $dateTime, 'Unexpected error on create date time from timestamp');

        return $dateTime;
    }

    final public static function fromTimestamp(int|float $timestamp): static
    {
        return static::createFromTimestamp($timestamp);
    }

    final public function jsonSerialize(): string
    {
        return $this->value();
    }

    final public function value(): string
    {
        return $this->format(self::FORMAT);
    }

    final public function modify(string $modifier): static | false
    {
        $dateTime = parent::modify($modifier);

        if (false === $dateTime) {
            return false;
        }

        return static::createFromInterface($dateTime);
    }

    final public function add(\DateInterval $interval): static
    {
        return parent::add($interval);
    }

    final public function setDate(int $year, int $month, int $day): static | false
    {
        $dateTime = parent::setDate($year, $month, $day);

        if (false === $dateTime) {
            return false;
        }

        return $dateTime;
    }

    final public function setISODate(int $year, int $week, int $dayOfWeek = 1): static | false
    {
        $dateTime = parent::setISODate($year, $week, $dayOfWeek);

        if (false === $dateTime) {
            return false;
        }

        return $dateTime;
    }

    final public function setTime(int $hour, int $minute, int $second = 0, int $microsecond = 0): static | false
    {
        $dateTime = parent::setTime($hour, $minute, $second, $microsecond);

        if (false === $dateTime) {
            return false;
        }

        return $dateTime;
    }

    final public function setTimestamp(int $timestamp): static
    {
        return parent::setTimestamp($timestamp);
    }

    final public function setTimezone(\DateTimeZone $timezone): static
    {
        return parent::setTimezone($timezone);
    }
}
