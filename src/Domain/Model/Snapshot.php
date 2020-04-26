<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model;

use PcComponentes\Ddd\Util\Message\AggregateMessage;

abstract class Snapshot extends AggregateMessage
{
    final public static function messageType(): string
    {
        return 'snapshot';
    }
}
