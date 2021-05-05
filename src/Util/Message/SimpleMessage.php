<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util\Message;

use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;

abstract class SimpleMessage extends Message
{
    final protected function __construct(Uuid $messageId, array $payload)
    {
        parent::__construct($messageId, $payload);
    }

    final public static function fromPayload(Uuid $messageId, array $payload): self
    {
        $message = new static($messageId, $payload);
        $message->assertPayload();

        return $message;
    }

    final public function accept(MessageVisitor $visitor): void
    {
        $visitor->visitSimpleMessage($this);
    }

    abstract protected function assertPayload(): void;
}
