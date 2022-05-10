<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

abstract class EnumValueObject extends StringValueObject
{
    private static array $allowedValues;

    public static function from(string $value): static
    {
        self::guard($value);

        return parent::from($value);
    }

    final public static function allowedValues(): array
    {
        if (!isset(self::$allowedValues[static::class])) {
            $reflection = new \ReflectionClass(static::class);
            self::$allowedValues[static::class] = $reflection->getConstants();
        }

        return self::$allowedValues[static::class];
    }

    private static function guard($value): void
    {
        if (false === self::isValid($value)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    '<%s> not allowed value, allowed values: <%s> for enum class <%s>',
                    $value,
                    \implode(' ', static::allowedValues()),
                    static::class,
                ),
            );
        }
    }

    private static function isValid($value): bool
    {
        return \in_array($value, static::allowedValues(), true);
    }
}
