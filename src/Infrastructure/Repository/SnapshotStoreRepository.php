<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Infrastructure\Repository;

use Pccomponentes\Ddd\Domain\Model\Snapshot;
use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;

interface SnapshotStoreRepository
{
    public function set(Snapshot $snapshot): void;
    public function get(Uuid $aggregateId): ?Snapshot;
    public function remove(Snapshot $snapshot): void;
}
