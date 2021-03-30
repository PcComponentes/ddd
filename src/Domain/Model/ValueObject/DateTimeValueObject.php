<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class DateTimeValueObject extends \DateTimeImmutable implements ValueObject
{
    final private function __construct($time, $timezone)
    {
        parent::__construct($time, $timezone);
    }

    final public static function from(string $str): static
    {
        return new static($str, new \DateTimeZone('UTC'));
    }

    final public static function now(): static
    {
        return static::from('now');
    }

    final public static function fromTimestamp(int $timestamp): static
    {
        $dateTime = \DateTimeImmutable::createFromFormat('U', (string) $timestamp);

        return static::from($dateTime->format(\DATE_ATOM));
    }

    final public function jsonSerialize(): string
    {
        return $this->format(\DATE_ATOM);
    }
}
