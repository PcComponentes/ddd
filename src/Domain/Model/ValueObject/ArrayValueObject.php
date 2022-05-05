<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

abstract class ArrayValueObject implements ValueObject
{
    private array $value;

    protected function __construct(array $value)
    {
        $this->value = $value;
    }

    public function value(): array
    {
        return $this->value;
    }

    public function equalTo(ArrayValueObject $other): bool
    {
        return static::class === \get_class($other) && $this->value === $other->value;
    }

    final public function jsonSerialize(): string
    {
        return \json_encode($this->value);
    }

    public static function from(array $value)
    {
        return new static($value);
    }
    
    public function __toString(): string
    {
        return \json_encode($this->value);
    }
}

