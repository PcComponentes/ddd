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
                    'occurred_on' => $this->mapDateTime($message->occurredOn()),
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

    private function mapDateTime(\DateTimeInterface $occurredOn): int|string
    {
        $occurredOnValue = $occurredOn->format($this->occurredOnFormat);

        if ((string) (int) $occurredOnValue === $occurredOnValue) {
            return (int) $occurredOnValue;
        }

        return $occurredOnValue;
    }
}
