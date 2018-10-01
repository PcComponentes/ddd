<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Infrastructure\Repository;

use Pccomponentes\Ddd\Domain\Model\DomainEvent;
use Pccomponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;

interface EventStoreRepository
{
    public function add(DomainEvent ...$events): void;
    public function get(Uuid $aggregateId): array;
    public function getSince(Uuid $aggregateId, DateTimeValueObject $since): array;

    public function getByMessageId(Uuid $messageId): DomainEvent;
    public function getByMessageName(string $messageName): array;
    public function getByMessageNameSince(string $messageName, DateTimeValueObject $since): array;
}
