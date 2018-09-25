<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Domain\Model;

use Pccomponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class AggregateRootTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_ask_to_launch_event_then_return_expected_info()
    {
        $aggregateId = Uuid::v4();
        $aggregateRoot = AggregateRootTested::test($aggregateId);

        $messageId = Uuid::v4();
        $occurredOn =DateTimeValueObject::from('2018-01-01 10:10:10');
        $event = DomainEventTested::test($messageId, $aggregateId, $occurredOn, []);

        $aggregateRoot->doAction($event);

        $this->assertEquals($aggregateId, $aggregateRoot->aggregateId());
        $this->assertEquals([$event], $aggregateRoot->events());
        $this->assertEquals($event, $aggregateRoot->applyDomainEventTestedEvent());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function given_unexpected_id_when_ask_to_launch_event_then_return_expected_info()
    {
        $aggregateId = Uuid::v4();
        $aggregateRoot = AggregateRootTested::test($aggregateId);

        $messageId = Uuid::v4();
        $otherAggregateId = Uuid::v4();
        $occurredOn =DateTimeValueObject::from('2018-01-01 10:10:10');
        $event = DomainEventTested::test($messageId, $otherAggregateId, $occurredOn, []);
        $aggregateRoot->doAction($event);
    }
}
