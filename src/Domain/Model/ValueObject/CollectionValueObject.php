<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

/**
 * Generic collection value object.
 *
 * @template TKey of array-key
 * @template TValue
 * @implements \IteratorAggregate<TKey, TValue>
 */
class CollectionValueObject implements \IteratorAggregate, \Countable, ValueObject
{
    /**
     * @var array<TKey, TValue>
     * Typed collection items.
     */
    private array $items;

    /** @param array<TKey, TValue> $items */
    final private function __construct(array $items)
    {
        $this->items = $items;
    }

    public static function from(array $items): static
    {
        return new static($items);
    }

    /** @return \Traversable<TKey, TValue> */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    /** @return TValue|null */
    public function current()
    {
        $key = $this->key();

        return null === $key
            ? null
            : $this->items[$key];
    }

    public function next(): void
    {
        \next($this->items);
    }

    /** @return TKey|null */
    public function key(): string|int|null
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

    /** @param callable(TValue, TKey): void $func */
    public function walk(callable $func): void
    {
        \array_walk($this->items, $func);
    }

    /**
     * @param callable(TValue): bool $func
     * @return TValue|null
     */
    public function findOne(callable $func)
    {
        return \array_find($this->items, $func);
    }

    /** @param callable(TValue): bool $func */
    public function filter(callable $func): static
    {
        return static::from(\array_values(\array_filter($this->items, $func)));
    }

    /** @param callable(TValue): TValue $func */
    public function map(callable $func): static
    {
        return static::from(\array_map($func, $this->items));
    }

    /**
     * @template TCarry
     * @param callable(TCarry, TValue): TCarry $func
     * @param TCarry $initial
     * @return TCarry
     */
    public function reduce(callable $func, $initial)
    {
        return \array_reduce($this->items, $func, $initial);
    }

    /** @param callable(TValue, TValue): int $func */
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

    public function equalTo(self $other): bool
    {
        return static::class === \get_class($other) && $this->items == $other->items;
    }

    public function equivalentTo(self $other): bool
    {
        if (static::class !== $other::class || $this->count() !== $other->count()) {
            return false;
        }

        $sortFunc = static fn ($a, $b) => $a <=> $b;

        $a = $this->sort($sortFunc);
        $b = $other->sort($sortFunc);

        return $a->equalTo($b);
    }

    /** @return array<TKey, TValue> */
    final public function jsonSerialize(): array
    {
        return $this->items;
    }

    /** @return TValue|null */
    public function first()
    {
        return $this->items[\array_key_first($this->items)] ?? null;
    }

    /** @return array<TKey, TValue> */
    public function value(): array
    {
        return $this->items;
    }

    /** @param TValue $item */
    protected function addItem($item): static
    {
        $items = $this->items;
        $items[] = $item;

        return static::from($items);
    }

    /** @param TValue $item */
    protected function removeItem($item): static
    {
        return $this->filter(
            static fn ($current) => $current !== $item,
        );
    }
}
