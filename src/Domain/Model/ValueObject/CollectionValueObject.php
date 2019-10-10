<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Domain\Model\ValueObject;

class CollectionValueObject implements \Iterator, \Countable, ValueObject
{
    private $items;

    protected function __construct(array $items)
    {
        $this->items = $items;
    }

    public function current()
    {
        $item = \current($this->items);

        return $item ? $item : null;
    }

    public function next()
    {
        $item = \next($this->items);

        return $item ? $item : null;
    }

    public function key()
    {
        return \key($this->items);
    }

    public function valid()
    {
        return \array_key_exists($this->key(), $this->items);
    }

    public function rewind()
    {
        $item = \reset($this->items);

        return $item ? $item : null;
    }

    public function count()
    {
        return \count($this->items);
    }

    public function walk(callable $func)
    {
        \array_walk($this->items, $func);
    }

    public function filter(callable $func)
    {
        return new static(\array_values(\array_filter($this->items, $func)));
    }

    public function map(callable $func): CollectionValueObject
    {
        return new static(\array_map($func, $this->items));
    }

    public function reduce(callable $func, $initial)
    {
        return \array_reduce($this->items, $func, $initial);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function equalTo(CollectionValueObject $other): bool
    {
        return \get_class($other) === static::class && $this->items == $other->items;
    }

    final public function jsonSerialize(): array
    {
        return $this->items;
    }

    protected function addItem($item): self
    {
        $items = $this->items;
        $items[] = $item;

        return new static($items);
    }

    protected function removeItem($item): self
    {
        return $this->filter(
            function ($current) use ($item) {
                return $current !== $item;
            }
        );
    }

    public static function from(array $items)
    {
        return new static($items);
    }
}
