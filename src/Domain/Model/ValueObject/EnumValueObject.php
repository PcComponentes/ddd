<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Domain\Model\ValueObject;

abstract class EnumValueObject extends StringValueObject
{
    private static $allowedValues;

    protected function __construct($value)
    {
        $this->guard($value);
        parent::__construct($value);
    }

    final public static function allowedValues(): array
    {
        if (!isset(self::$allowedValues[static::class])) {
            $reflection = new \ReflectionClass(static::class);
            self::$allowedValues[static::class] = $reflection->getConstants();
        }

        return self::$allowedValues[static::class];
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
