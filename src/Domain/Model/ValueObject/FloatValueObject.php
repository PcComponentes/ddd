<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

abstract class FloatValueObject implements ValueObject
{
    private float $value;

    final private function __construct(float $value)
    {
        $this->value = $value;
    }

    public static function from(float $value): static
    {
        return new static($value);
    }

    public function value(): float
    {
        return $this->value;
    }

    public function equalTo(FloatValueObject $other): bool
    {
        return static::class === \get_class($other) && $other->value === $this->value;
    }

    public function isBiggerThan(FloatValueObject $other): bool
    {
        return static::class === \get_class($other) && $this->value > $other->value;
    }

    final public function jsonSerialize(): float
    {
        return $this->value;
    }
}
