<?php

declare(strict_types=1);
namespace PcComponentes\Ddd\Tests\Util\Message;

use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class SimpleMessageTest extends TestCase
{
    /**
     * @test
     */
    public function given_data_when_ask_to_create_message_then_create_it()
    {
        SimpleMessageTested::set('example', 'v1', 'tested');
        $messageId = Uuid::from('212e0a16-ae32-4c80-a6e4-26577f4cf7c7');
        $payload = [
            'test' => 12345,
        ];

        $message = SimpleMessageTested::fromPayload($messageId, $payload);
        $this->assertEquals($messageId, $message->messageId());
        $this->assertEquals($payload, $message->messagePayload());
        $this->assertTrue($message->assertPayloadCalled());
    }
}
