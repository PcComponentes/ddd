<?php

declare(strict_types=1);
namespace PcComponentes\Ddd\Tests\Util\Message;

use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;
use PcComponentes\Ddd\Util\Message\ValueObject\AggregateId;
use PHPUnit\Framework\TestCase;

class AggregatemessageTest extends TestCase
{
    /**
     * @test
     */
    public function given_message_when_ask_to_serialize_then_return_expected_info()
    {
        AggregateMessageTested::set('example', 'v1', 'tested');
        $messageId = Uuid::from('212e0a16-ae32-4c80-a6e4-26577f4cf7c7');
        $aggregateId = AggregateId::from('bdb507b6-838b-46ff-9aeb-53ab8ac01e33');
        $occurredOn = DateTimeValueObject::from('2018-01-01 01:01:01');
        $aggregateVersion = 0;
        $payload = [
            'test' => 12345,
            'other' => 'ok'
        ];

        $tested =  AggregateMessageTested::fromPayload($messageId, $aggregateId, $occurredOn, $payload, $aggregateVersion);
        $this->assertEquals($aggregateId->value(), $tested->aggregateId()->value());
        $this->assertEquals($occurredOn, $tested->occurredOn());
        $this->assertTrue($tested->assertPayloadCalled());

        $expected = [
            'message_id' => $messageId->value(),
            'name' => 'example',
            'version' => 'v1',
            'type' => 'tested',
            'payload' => $payload,
            'aggregate_version' => $aggregateVersion,
            'aggregate_id' => $aggregateId->value(),
            'occurred_on' => \json_decode(\json_encode($occurredOn), true)
        ];
        $this->assertEquals($expected, \json_decode(\json_encode($tested), true));
    }
}
