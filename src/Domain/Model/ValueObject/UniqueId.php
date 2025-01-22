<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class UniqueId extends StringValueObject
{
    private const VALID_PATTERN = '/^[A-Z0-9]{10}$/';

    public static function from(string $value): static
    {
        if (false === self::isValid($value)) {
            throw new \InvalidArgumentException('Invalid UniqueId.');
        }

        return parent::from($value);
    }

    public static function create(): static
    {
        return self::from(
            \strtoupper(\base_convert(\uniqid(), 16, 36)),
        );
    }

    public static function isValid(string $value): bool
    {
        return 1 === \preg_match(self::VALID_PATTERN, $value);
    }
}
