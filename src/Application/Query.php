<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Application;

use PcComponentes\Ddd\Util\Message\SimpleMessage;

abstract class Query extends SimpleMessage
{
    final public static function messageType(): string
    {
        return 'query';
    }
}
