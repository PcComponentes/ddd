<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Domain\Model;

use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;

abstract class AggregateRoot implements \JsonSerializable
{
    private $aggregateId;
    private $events;
    private $aggregateVersion;

    final protected function __construct(Uuid $aggregateId, int $aggregateVersion = 0)
    {
        $this->aggregateId = $aggregateId;
        $this->events = [];
        $this->aggregateVersion = $aggregateVersion;
    }

    final public function aggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    final protected function recordThat(DomainEvent $event): void
    {
        $this->events[] = $event;
        $this->apply($event);
        $this->aggregateVersion = $this->aggregateVersion + 1;
    }

    final protected function apply(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            if (false === $this->aggregateId->equalTo($event->aggregateId())) {
                throw new \InvalidArgumentException(
                    \sprintf(
                        'The event with id %s not matching with the aggregate root with id %s.',
                        $event->aggregateId()->value(),
                        $this->aggregateId->value()
                    )
                );
            }

            $class = \explode('\\', \get_class($event));
            $className = \end($class);
            $this->{'apply' . $className}($event);
        }
    }

    final public function events(): array
    {
        return $this->events;
    }

    final public function aggregateVersion(): int
    {
        return $this->aggregateVersion;
    }

    final public static function reconstitute(Uuid $id, DomainEvent ...$events): self
    {
        if (0 === count($events)) {
            throw new \InvalidArgumentException('Can`t reconstitute without events');
        }

        $self = new static($id);
        $self->apply(...$events);
        $self->aggregateVersion = \end($events)->aggregateVersion();

        return $self;
    }

    final public function replay(DomainEvent ...$events): self
    {
        if (0 === count($events)) {
            throw new \InvalidArgumentException('Can`t replay without events');
        }
        $this->apply(...$events);
        $this->aggregateVersion = \end($events)->aggregateVersion();

        return $this;
    }

    abstract public static function modelName(): string;
}
