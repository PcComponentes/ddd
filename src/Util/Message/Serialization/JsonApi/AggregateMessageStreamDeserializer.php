<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util\Message\Serialization\JsonApi;

use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;
use PcComponentes\Ddd\Util\Message\AggregateMessage;
use PcComponentes\Ddd\Util\Message\Serialization\AggregateMessageUnserializable;
use PcComponentes\Ddd\Util\Message\Serialization\Exception\MessageClassNotFoundException;
use PcComponentes\Ddd\Util\Message\Serialization\MessageMappingRegistry;
use PcComponentes\Ddd\Util\Message\ValueObject\AggregateId;

final class AggregateMessageStreamDeserializer implements AggregateMessageUnserializable
{
    private MessageMappingRegistry $registry;
    private string $occurredOnFormat;

    public function __construct(MessageMappingRegistry $registry, string $occurredOnFormat = 'U')
    {
        $this->registry = $registry;
        $this->occurredOnFormat = $occurredOnFormat;
    }

    /** @param AggregateMessageStream $message */
    public function unserialize($message): AggregateMessage
    {
        if (false === $message instanceof AggregateMessageStream) {
            throw new \LogicException(self::class . ' only works with ' . AggregateMessageStream::class);
        }

        $eventClass = ($this->registry)($message->messageName());

        if (null === $eventClass || false === \class_exists($eventClass)) {
            throw new MessageClassNotFoundException(\sprintf('Message %s not found', $message->messageName()));
        }

        return $eventClass::fromPayload(
            Uuid::from($message->messageId()),
            AggregateId::from($message->aggregateId()),
            DateTimeValueObject::fromFormat($this->occurredOnFormat, $message->occurredOn()),
            \json_decode($message->payload(), true, 512, \JSON_THROW_ON_ERROR),
            $message->aggregateVersion(),
        );
    }
}
