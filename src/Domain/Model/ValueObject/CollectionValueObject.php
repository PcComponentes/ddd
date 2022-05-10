<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

class CollectionValueObject implements \Iterator, \Countable, ValueObject
{
    private array $items;

    final private function __construct(array $items)
    {
        $this->items = $items;
    }

    public static function from(array $items): static
    {
        return new static($items);
    }

    public function current()
    {
        return \current($this->items);
    }

    public function next(): void
    {
        \next($this->items);
    }

    public function key()
    {
        return \key($this->items);
    }

    public function valid(): bool
    {
        return \array_key_exists($this->key(), $this->items);
    }

    public function rewind(): void
    {
        \reset($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function walk(callable $func): void
    {
        \array_walk($this->items, $func);
    }

    public function filter(callable $func): static
    {
        return static::from(\array_values(\array_filter($this->items, $func)));
    }

    public function map(callable $func): static
    {
        return static::from(\array_map($func, $this->items));
    }

    public function reduce(callable $func, $initial)
    {
        return \array_reduce($this->items, $func, $initial);
    }

    public function sort(callable $func): static
    {
        $items = $this->items;
        \usort($items, $func);

        return static::from($items);
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

    public function first()
    {
        return $this->items[array_key_first($this->items)] ?? null;
    }

    protected function addItem($item): static
    {
        $items = $this->items;
        $items[] = $item;

        return static::from($items);
    }

    protected function removeItem($item): static
    {
        return $this->filter(
            static fn ($current) => $current !== $item,
        );
    }
}
