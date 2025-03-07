<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class IntValueObject implements ValueObject
{
    private int $value;

    final private function __construct(int $value)
    {
        $this->value = $value;
    }

    public static function from(int $value): static
    {
        return new static($value);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equalTo(IntValueObject $other): bool
    {
        return static::class === \get_class($other) && $this->value === $other->value;
    }

    public function isBiggerThan(IntValueObject $other): bool
    {
        return static::class === \get_class($other) && $this->value > $other->value;
    }

    final public function jsonSerialize(): int
    {
        return $this->value;
    }
}
