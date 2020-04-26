<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util\Message\Serialization;

use PcComponentes\Ddd\Util\Message\SimpleMessage;

interface SimpleMessageUnserializable
{
    public function unserialize($message): SimpleMessage;
}
