<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Util\Message;

use Pccomponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;

abstract class AggregateMessage extends Message
{
    private $aggregateId;
    private $occurredOn;

    final protected function __construct(
        Uuid $messageId,
        Uuid $aggregateId,
        DateTimeValueObject $occurredOn,
        array $payload
    ) {
        parent::__construct($messageId, $payload);
        $this->aggregateId = $aggregateId;
        $this->occurredOn = $occurredOn;
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
                'occurred_on' => $this->occurredOn
            ]
        );
    }

    final public static function fromPayload(
        Uuid $messageId,
        Uuid $aggregateId,
        DateTimeValueObject $occurredOn,
        array $payload
    ): self {
        $message = new static($messageId, $aggregateId, $occurredOn, $payload);
        $message->assertPayload();

        return $message;
    }

    abstract protected function assertPayload(): void;
}
