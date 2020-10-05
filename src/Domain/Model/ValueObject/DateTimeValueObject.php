<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class DateTimeValueObject extends \DateTimeImmutable implements ValueObject
{
    public function __construct($time = 'now', $timezone = null)
    {
        if (null === $timezone) {
            $timezone = new \DateTimeZone('UTC');
        }

        parent::__construct($time, $timezone);
    }

    final public static function from(string $str): self
    {
        return new static($str, new \DateTimeZone('UTC'));
    }

    final public static function fromTimestamp(int $timestamp): self
    {
        $dateTime = \DateTimeImmutable::createFromFormat('U', (string) $timestamp);

        return static::from($dateTime->format(\DATE_ATOM));
    }

    final public function jsonSerialize(): string
    {
        return $this->format(\DATE_ATOM);
    }
}
