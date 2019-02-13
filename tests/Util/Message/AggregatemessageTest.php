<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Util\Message;

use Pccomponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;
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
        $aggregateId = Uuid::from('bdb507b6-838b-46ff-9aeb-53ab8ac01e33');
        $occurredOn = DateTimeValueObject::from('2018-01-01 01:01:01');
        $aggregateVersion = 0;
        $payload = [
            'test' => 12345,
            'other' => 'ok'
        ];

        $tested =  AggregateMessageTested::fromPayload($messageId, $aggregateId, $occurredOn, $payload, $aggregateVersion);
        $this->assertEquals($aggregateId, $tested->aggregateId());
        $this->assertEquals($occurredOn, $tested->occurredOn());
        $this->assertTrue($tested->assertPayloadCalled());

        $expected = [
            'message_id' => $messageId,
            'name' => 'example',
            'version' => 'v1',
            'type' => 'tested',
            'payload' => $payload,
            'aggregate_version' => $aggregateVersion,
            'aggregate_id' => $aggregateId,
            'occurred_on' => $occurredOn
        ];
        $this->assertEquals($expected, $tested->jsonSerialize());
    }
}
