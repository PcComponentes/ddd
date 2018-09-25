<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Domain\Model\ValueObject;

abstract class BoolValueObject implements ValueObject
{
    private $value;

    protected function __construct(bool $value)
    {
        $this->value = $value;
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

    public static function from(bool $value)
    {
        return new static($value);
    }

    public static function true()
    {
        return new static(true);
    }

    public static function false()
    {
        return new static(false);
    }
}
