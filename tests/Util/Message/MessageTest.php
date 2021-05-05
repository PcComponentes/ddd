<?php

declare(strict_types=1);
namespace PcComponentes\Ddd\Tests\Util\Message;

use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /**
     * @test
     */
    public function given_message_when_ask_to_name_and_version_and_type_then_return_expected_info()
    {
        MessageTested::set('example', 'v1', 'tested');
        $this->assertEquals('example', MessageTested::messageName());
        $this->assertEquals('v1', MessageTested::messageVersion());
        $this->assertEquals('tested', MessageTested::messageType());
    }

    /**
     * @test
     */
    public function given_message_when_ask_to_serialize_then_return_expected_info()
    {
        MessageTested::set('example', 'v1', 'tested');
        $messageId = Uuid::from('212e0a16-ae32-4c80-a6e4-26577f4cf7c7');
        $payload = [
            'test' => 12345,
            'other' => 'ok'
        ];

        $tested =  MessageTested::test($messageId, $payload);
        $this->assertEquals($messageId, $tested->messageId());
        $this->assertEquals($payload, $tested->messagePayload());

        $expected = [
            'message_id' => $messageId,
            'name' => 'example',
            'version' => 'v1',
            'type' => 'tested',
            'payload' => $payload
        ];
        $this->assertEquals($expected, $tested->jsonSerialize());
    }

    /**
     * @test
     *
     */
    public function given_non_primitive_payload_when_ask_to_create_message_then_throw_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        MessageTested::set('example', 'v1', 'tested');
        $messageId = Uuid::from('212e0a16-ae32-4c80-a6e4-26577f4cf7c7');
        $payload = [
            'date' => new \DateTimeImmutable('now'),
        ];
        MessageTested::test($messageId, $payload);
    }
}
