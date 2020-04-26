<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model;

use PcComponentes\Ddd\Util\Message\AggregateMessage;

abstract class DomainEvent extends AggregateMessage
{
    final public static function messageType(): string
    {
        return 'domain_event';
    }
}
