<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class DateValueObject extends \DateTimeImmutable implements ValueObject
{
    private const TIME_ZONE = 'UTC';
    private const FORMAT = 'Y-m-d';

    final private function __construct(string $time, \DateTimeZone $timezone)
    {
        parent::__construct($time, $timezone);
    }

    final public static function from(string $str): static
    {
        return new static($str, new \DateTimeZone(self::TIME_ZONE));
    }

    final public static function now(): static
    {
        return static::from('now');
    }

    final public static function fromFormat(string $format, string $str): static
    {
        $dateTime = \DateTimeImmutable::createFromFormat($format, $str, new \DateTimeZone(self::TIME_ZONE));

        \assert($dateTime instanceof \DateTimeImmutable);

        return static::from($dateTime->format(self::FORMAT));
    }

    final public static function fromTimestamp(int $timestamp): static
    {
        return self::fromFormat('U', (string) $timestamp);
    }

    final public function jsonSerialize(): string
    {
        return $this->format(self::FORMAT);
    }

    final public function value(): string
    {
        return $this->format(self::FORMAT);
    }
}
