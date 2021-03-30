<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util\Message;

use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;

abstract class AggregateMessage extends Message
{
    private Uuid $aggregateId;
    private DateTimeValueObject $occurredOn;
    private int $aggregateVersion;

    final protected function __construct(
        Uuid $messageId,
        Uuid $aggregateId,
        int $aggregateVersion,
        DateTimeValueObject $occurredOn,
        array $payload
    ) {
        parent::__construct($messageId, $payload);

        $this->aggregateId = $aggregateId;
        $this->aggregateVersion = $aggregateVersion;
        $this->occurredOn = $occurredOn;
    }

    final public static function fromPayload(
        Uuid $messageId,
        Uuid $aggregateId,
        DateTimeValueObject $occurredOn,
        array $payload,
        int $aggregateVersion = 0
    ): self {
        $message = new static($messageId, $aggregateId, $aggregateVersion, $occurredOn, $payload);
        $message->assertPayload();

        return $message;
    }

    final public function aggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    final public function occurredOn(): \DateTimeInterface
    {
        return $this->occurredOn;
    }

    final public function jsonSerialize()
    {
        return \array_merge(
            parent::jsonSerialize(),
            [
                'aggregate_id' => $this->aggregateId,
                'aggregate_version' => $this->aggregateVersion,
                'occurred_on' => $this->occurredOn,
            ],
        );
    }

    final public function aggregateVersion(): int
    {
        return $this->aggregateVersion;
    }

    final public function accept(MessageVisitor $visitor): void
    {
        $visitor->visitAggregateMessage($this);
    }

    abstract protected function assertPayload(): void;
}
