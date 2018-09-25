<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Domain\Model;

use Pccomponentes\Ddd\Domain\Model\AggregateRoot;
use Pccomponentes\Ddd\Domain\Model\DomainEvent;
use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;

class AggregateRootTested extends AggregateRoot
{
    private $applyDomainEventTestedEvent;

    public static function test(Uuid $aggregateId): self
    {
        return new self($aggregateId);
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
