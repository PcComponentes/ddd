<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Util\Message;

use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;

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

    abstract protected function assertPayload(): void;
}
