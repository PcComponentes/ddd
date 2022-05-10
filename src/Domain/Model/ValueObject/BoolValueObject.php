<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

abstract class BoolValueObject implements ValueObject
{
    private bool $value;

    final private function __construct(bool $value)
    {
        $this->value = $value;
    }

    public static function from(bool $value): static
    {
        return new static($value);
    }

    public static function true(): static
    {
        return static::from(true);
    }

    public static function false(): static
    {
        return static::from(false);
    }

    public function value(): bool
    {
        return $this->value;
    }

    public function isTrue(): bool
    {
        return true === $this->value;
    }

    public function isFalse(): bool
    {
        return false === $this->value;
    }

    final public function jsonSerialize(): bool
    {
        return $this->value;
    }
}
