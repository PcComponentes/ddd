<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

abstract class FloatValueObject implements ValueObject
{
    private float $value;

    protected function __construct(float $value)
    {
        $this->value = $value;
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

    public static function from(float $value)
    {
        return new static($value);
    }
}
