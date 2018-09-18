<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Domain\Model\ValueObject;

abstract class EnumValueObject extends StringValueObject
{
    private static $allowedValues = false;

    protected function __construct($value)
    {
        $this->guard($value);
        parent::__construct($value);
    }

    final public static function allowedValues(): array
    {
        if (false === self::$allowedValues) {
            $reflection = new \ReflectionClass(static::class);
            self::$allowedValues = $reflection->getConstants();
        }

        return self::$allowedValues;
    }

    private function guard($value): void
    {
        if (false === $this->isValid($value)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '<%s> not allowed value, allowed values: <%s> for enum class <$s>',
                    $value,
                    implode(' ', static::allowedValues()),
                    static::class
                )
            );
        }
    }

    private function isValid($value): bool
    {
        return \in_array($value, static::allowedValues(), true);
    }
}
