<?php declare(strict_types=1);

namespace Pccomponentes\Ddd\Util\Message\Serialization\JsonApi;

use Pccomponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;
use Pccomponentes\Ddd\Util\Message\AggregateMessage;
use Pccomponentes\Ddd\Util\Message\Serialization\AggregateMessageUnserializable;
use Pccomponentes\Ddd\Util\Message\Serialization\Exception\MessageClassNotFoundException;
use Pccomponentes\Ddd\Util\Message\Serialization\MessageMappingRegistry;

final class AggregateMessageStreamDeserializer implements AggregateMessageUnserializable
{
    private $registry;

    public function __construct(MessageMappingRegistry $registry)
    {
        $this->registry = $registry;
    }

    /** @var AggregateMessageStream $message */
    public function unserialize($message): AggregateMessage
    {
        if (false === $message instanceof AggregateMessageStream) {
            throw new \LogicException(self::class . ' only works with ' . AggregateMessageStream::class);
        }
        /** @var AggregateMessage $eventClass */
        $eventClass = ($this->registry)($message->messageName());

        if (null === $eventClass || false === class_exists($eventClass)) {
            throw new MessageClassNotFoundException(sprintf('Message %s not found', $message->messageName()));
        }

        return $eventClass::fromPayload(
            Uuid::from($message->messageId()),
            Uuid::from($message->aggregateId()),
            DateTimeValueObject::fromTimestamp($message->occurredOn()),
            \json_decode($message->payload(), true),
            $message->aggregateVersion()
        );
    }
}
