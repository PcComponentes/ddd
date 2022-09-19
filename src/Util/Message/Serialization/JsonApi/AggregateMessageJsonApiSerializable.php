<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util\Message\Serialization\JsonApi;

use PcComponentes\Ddd\Util\Message\AggregateMessage;
use PcComponentes\Ddd\Util\Message\Serialization\AggregateMessageSerializable;

final class AggregateMessageJsonApiSerializable implements AggregateMessageSerializable
{
    private string $occurredOnFormat;

    public function __construct(string $occurredOnFormat = 'U')
    {
        $this->occurredOnFormat = $occurredOnFormat;
    }

    public function serialize(AggregateMessage $message)
    {
        return \json_encode(
            [
                'data' => [
                    'message_id' => $message->messageId(),
                    'type' => $message::messageName(),
                    'occurred_on' => $message->occurredOn()->format($this->occurredOnFormat),
                    'attributes' => \array_merge(
                        ['aggregate_id' => $message->aggregateId()->value()],
                        $message->messagePayload(),
                    ),
                ],
            ],
            \JSON_THROW_ON_ERROR,
            512,
        );
    }
}
