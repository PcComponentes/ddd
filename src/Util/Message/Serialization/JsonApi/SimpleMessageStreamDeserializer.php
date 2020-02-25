<?php declare(strict_types=1);

namespace Pccomponentes\Ddd\Util\Message\Serialization\JsonApi;

use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;
use Pccomponentes\Ddd\Util\Message\Serialization\Exception\MessageClassNotFoundException;
use Pccomponentes\Ddd\Util\Message\Serialization\MessageMappingRegistry;
use Pccomponentes\Ddd\Util\Message\Serialization\SimpleMessageUnserializable;
use Pccomponentes\Ddd\Util\Message\SimpleMessage;

final class SimpleMessageStreamDeserializer implements SimpleMessageUnserializable
{
    private $registry;

    public function __construct(MessageMappingRegistry $registry)
    {
        $this->registry = $registry;
    }

    /** @var SimpleMessageStream $message */
    public function unserialize($message): SimpleMessage
    {
        if (false === $message instanceof SimpleMessageStream) {
            throw new \LogicException(self::class . ' only works with ' . SimpleMessageStream::class);
        }
        /** @var SimpleMessage $messageClass */
        $messageClass = ($this->registry)($message->messageName());

        if (null === $messageClass || false === class_exists($messageClass)) {
            throw new MessageClassNotFoundException(sprintf('Message %s not found', $message->messageName()));
        }

        return $messageClass::fromPayload(
            Uuid::from($message->messageId()),
            \json_decode($message->payload(), true)
        );
    }
}
