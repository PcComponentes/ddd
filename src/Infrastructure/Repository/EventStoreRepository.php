<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Infrastructure\Repository;

use PcComponentes\Ddd\Domain\Model\DomainEvent;
use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;

interface EventStoreRepository
{
    public function add(DomainEvent ...$events): void;

    public function get(Uuid $aggregateId): array;

    public function getSince(Uuid $aggregateId, DateTimeValueObject $since): array;

    public function getByMessageId(Uuid $messageId): ?DomainEvent;

    public function getByMessageName(string $messageName): array;

    public function getByMessageNameSince(string $messageName, DateTimeValueObject $since): array;
}
