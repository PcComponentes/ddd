<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid extends StringValueObject
{
    public static function from(string $value): Uuid
    {
        return new static(RamseyUuid::fromString($value)->toString());
    }

    public static function v4(): Uuid
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    public static function isValid(string $value): bool
    {
        return RamseyUuid::isValid($value);
    }
}
