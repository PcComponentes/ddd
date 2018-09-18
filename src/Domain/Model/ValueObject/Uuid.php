<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Domain\Model\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid extends StringValueObject
{
    public static function from(string $value)
    {
        return new static(RamseyUuid::fromString($value)->toString());
    }

    public static function v4()
    {
        return new static(RamseyUuid::uuid4()->toString());
    }
}
