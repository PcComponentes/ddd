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

    final protected function __construct(Uuid $aggregateId)
    {
        $this->aggregateId = $aggregateId;
        $this->events = [];
    }

    final public function aggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    final protected function recordThat(DomainEvent $event): void
    {
        $this->events[] = $event;
        $this->apply($event);
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

    abstract public static function modelName(): string;
}
