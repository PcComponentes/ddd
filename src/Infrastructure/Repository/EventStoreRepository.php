<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
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
}
