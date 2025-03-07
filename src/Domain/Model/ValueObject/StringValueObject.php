<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class StringValueObject implements ValueObject
{
    private string $value;

    final private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function from(string $value): static
    {
        return new static($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equalTo(StringValueObject $other): bool
    {
        return static::class === \get_class($other) && $this->value === $other->value;
    }

    final public function jsonSerialize(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
