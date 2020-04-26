<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util\Message\Serialization;

use PcComponentes\Ddd\Util\Message\AggregateMessage;

interface AggregateMessageSerializable
{
    public function serialize(AggregateMessage $message);
}
