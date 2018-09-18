<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Domain\Model\ValueObject;

abstract class IntValueObject implements ValueObject
{
    private $value;

    protected function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equalTo(IntValueObject $other): bool
    {
        return \get_class($other) === static::class && $this->value === $other->value;
    }

    public function isBiggerThan(IntValueObject $other): bool
    {
        return \get_class($other) === static::class && $this->value > $other->value;
    }

    final public function jsonSerialize(): int
    {
        return $this->value;
    }

    public static function from(int $value)
    {
        return new static($value);
    }
}
