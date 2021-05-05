<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid extends StringValueObject
{
    public static function from(string $value): static
    {
        return parent::from(RamseyUuid::fromString($value)->toString());
    }

    public static function v4(): static
    {
        return static::from(RamseyUuid::uuid4()->toString());
    }
}
