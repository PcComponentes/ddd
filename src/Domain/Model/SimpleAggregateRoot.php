<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model;

use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;
use PcComponentes\Ddd\Util\Message\AggregateMessage;

abstract class SimpleAggregateRoot
{
    private Uuid $aggregateId;
    private array $events;

    final protected function __construct(Uuid $aggregateId)
    {
        $this->aggregateId = $aggregateId;
        $this->events = [];
    }

    abstract public static function modelName(): string;

    final public function aggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    final public function events(): array
    {
        return $this->events;
    }

    final protected function recordThat(AggregateMessage $event): void
    {
        $this->events[] = $event;
    }
}
