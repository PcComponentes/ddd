<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Domain\Model;

use Pccomponentes\Ddd\Util\Message\AggregateMessage;

abstract class Snapshot extends AggregateMessage
{
    final public static function messageType(): string
    {
        return 'snapshot';
    }
}
