<?php declare(strict_types=1);

namespace PcComponentes\Ddd\Tests\Domain\Model;

use PcComponentes\Ddd\Domain\Model\SimpleAggregateRoot;
use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;

final class SimpleAggregateRootTested extends SimpleAggregateRoot
{
    public static function test(Uuid $aggregateId): self
    {
        $self = new self($aggregateId);

        $self->recordThat(
            DomainEventTested::fromPayload(
                Uuid::v4(),
                $aggregateId,
                new DateTimeValueObject(),
                []
            )
        );

        return $self;
    }

    public static function modelName(): string
    {
        return 'foo';
    }
}
