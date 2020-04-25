<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util;

class AssocAccessor
{
    public static function get(array $array, $index)
    {
        $indexes = \explode('.', $index);
        $first = \array_shift($indexes);

        if (false === \array_key_exists($first, $array)) {
            throw new \InvalidArgumentException(
                \sprintf('Undefined index %s in array.', $first),
            );
        }

        return $indexes
            ? static::get($array[$first], \implode('.', $indexes))
            : $array[$first];
    }

    public static function getOrDefault(array $array, $index, $default)
    {
        $indexes = \explode('.', $index);
        $first = \array_shift($indexes);

        if (false === \array_key_exists($first, $array)) {
            return $default;
        }

        return $indexes
            ? static::getOrDefault($array[$first], \implode('.', $indexes), $default)
            : $array[$first];
    }
}
