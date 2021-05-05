<?php

declare(strict_types=1);
namespace PcComponentes\Ddd\Tests\Domain\Model;

use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class AggregateRootTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_ask_to_launch_event_then_return_expected_info()
    {
        $aggregateId = Uuid::v4();
        $aggregateVersion = 2;
        $aggregateRoot = AggregateRootTested::test($aggregateId, $aggregateVersion);

        $messageId = Uuid::v4();
        $occurredOn =DateTimeValueObject::from('2018-01-01 10:10:10');
        $event = DomainEventTested::test($messageId, $aggregateId, $aggregateVersion, $occurredOn, []);

        $aggregateRoot->doAction($event);

        $this->assertEquals($aggregateId, $aggregateRoot->aggregateId());
        $this->assertEquals([$event], $aggregateRoot->events());
        $this->assertEquals($event, $aggregateRoot->applyDomainEventTestedEvent());
        $this->assertEquals($aggregateVersion, $event->aggregateVersion());
        $this->assertEquals($aggregateVersion + 1, $aggregateRoot->aggregateVersion());
    }

    /**
     * @test
     */
    public function given_unexpected_id_when_ask_to_launch_event_then_return_expected_info()
    {
        $aggregateId = Uuid::v4();
        $aggregateVersion = 0;
        $aggregateRoot = AggregateRootTested::test($aggregateId, $aggregateVersion);

        $messageId = Uuid::v4();
        $otherAggregateId = Uuid::v4();
        $occurredOn = DateTimeValueObject::from('2018-01-01 10:10:10');
        $event = DomainEventTested::test($messageId, $otherAggregateId, $aggregateVersion, $occurredOn, []);

        $this->expectException(\InvalidArgumentException::class);

        $aggregateRoot->doAction($event);
    }

    /**
     * @test
     */
    public function given_collection_of_events_when_reconstitute_then_return_expected_info()
    {
        $aggregateId = Uuid::v4();
        $aggregateVersion = 4;

        $messageId = Uuid::v4();
        $occurredOn = DateTimeValueObject::from('2018-01-01 10:10:10');
        $event = DomainEventTested::test($messageId, $aggregateId, $aggregateVersion, $occurredOn, []);

        $aggregateRoot = AggregateRootTested::reconstitute($aggregateId, ...[$event]);

        $this->assertEquals($aggregateVersion, $aggregateRoot->aggregateVersion());
    }

    /**
     * @test
     */
    public function given_instantiated_aggregate_root_when_replay_then_return_expected_info()
    {
        $aggregateId = Uuid::v4();
        $aggregateVersion = 0;

        $aggregateRoot = AggregateRootTested::test($aggregateId, $aggregateVersion);

        $messageId = Uuid::v4();
        $occurredOn = DateTimeValueObject::from('2018-01-01 10:10:10');
        $aggregateVersionInEvent = 1;
        $event = DomainEventTested::test($messageId, $aggregateId, $aggregateVersionInEvent, $occurredOn, []);

        $aggregateRoot->replay(...[$event]);

        $this->assertEquals($aggregateVersionInEvent, $aggregateRoot->aggregateVersion());
    }

    /**
     * @test
     */
    public function given_none_events_when_reconstitute_then_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $aggregateId = Uuid::v4();
        AggregateRootTested::reconstitute($aggregateId, ...[]);
    }

    /**
     * @test
     */
    public function given_none_events_when_replay_then_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $aggregateId = Uuid::v4();
        $aggregateVersion = 0;
        $aggregateRoot = AggregateRootTested::test($aggregateId, $aggregateVersion);

        $aggregateRoot->replay(...[]);
    }
}
