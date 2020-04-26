<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Infrastructure\Repository;

use PcComponentes\Ddd\Domain\Model\Snapshot;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;

interface SnapshotStoreRepository
{
    public function set(Snapshot $snapshot): void;

    public function get(Uuid $aggregateId): ?Snapshot;

    public function remove(Snapshot $snapshot): void;
}
