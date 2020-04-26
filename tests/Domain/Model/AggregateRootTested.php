<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace PcComponentes\Ddd\Tests\Domain\Model;

use PcComponentes\Ddd\Domain\Model\AggregateRoot;
use PcComponentes\Ddd\Domain\Model\DomainEvent;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;

class AggregateRootTested extends AggregateRoot
{
    private $applyDomainEventTestedEvent;

    public static function test(Uuid $aggregateId, int $aggregateVersion): self
    {
        return new self($aggregateId, $aggregateVersion);
    }

    public static function modelName(): string
    {
        return 'example';
    }

    public function jsonSerialize()
    {
        return null;
    }

    public function doAction(DomainEvent $event): void
    {
        $this->recordThat($event);
    }

    public function applyDomainEventTested(DomainEventTested $event): void
    {
        $this->applyDomainEventTestedEvent = $event;
    }

    public function applyDomainEventTestedEvent(): DomainEvent
    {
        return $this->applyDomainEventTestedEvent;
    }
}
