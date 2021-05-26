<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class CollectionValueObject implements \Iterator, \Countable, ValueObject
{
    private array $items;

    protected function __construct(array $items)
    {
        $this->items = $items;
    }

    public function current()
    {
        return \current($this->items);
    }

    public function next()
    {
        \next($this->items);
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
        \reset($this->items);
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

    public function sort(callable $func)
    {
        $items = $this->items;
        \usort($items, $func);

        return new static($items);
    }

    public function isEmpty(): bool
    {
        return 0 === $this->count();
    }

    public function equalTo(CollectionValueObject $other): bool
    {
        return static::class === \get_class($other) && $this->items == $other->items;
    }

    final public function jsonSerialize(): array
    {
        return $this->items;
    }

    public static function from(array $items)
    {
        return new static($items);
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
            static fn ($current) => $current !== $item,
        );
    }

    public function first()
    {
        return $this->items[array_key_first($this->items)] ?? null;
    }
}
