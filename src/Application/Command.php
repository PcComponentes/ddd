<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Application;

use Pccomponentes\Ddd\Util\Message\SimpleMessage;

abstract class Command extends SimpleMessage
{
    final public static function messageType(): string
    {
        return 'command';
    }
}
