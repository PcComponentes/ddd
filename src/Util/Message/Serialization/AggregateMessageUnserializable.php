<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util\Message\Serialization;

use PcComponentes\Ddd\Util\Message\AggregateMessage;

interface AggregateMessageUnserializable
{
    public function unserialize($message): AggregateMessage;
}
