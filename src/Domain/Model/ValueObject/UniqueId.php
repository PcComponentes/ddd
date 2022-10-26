<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class UniqueId extends StringValueObject
{
    public static function create(): static
    {
        return self::from(
            \strtoupper(\base_convert(\uniqid(), 16, 36)),
        );
    }
}
