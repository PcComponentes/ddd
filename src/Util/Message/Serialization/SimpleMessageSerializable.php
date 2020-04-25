<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util\Message\Serialization;

use PcComponentes\Ddd\Util\Message\SimpleMessage;

interface SimpleMessageSerializable
{
    public function serialize(SimpleMessage $message);
}
