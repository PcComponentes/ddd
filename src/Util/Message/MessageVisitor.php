<?php declare(strict_types=1);

namespace Pccomponentes\Ddd\Util\Message;

interface MessageVisitor
{
    public function visitSimpleMessage(SimpleMessage $simpleMessage): void;
    public function visitAggregateMessage(AggregateMessage $aggregateMessage): void;
}
