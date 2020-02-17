<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Util\Message;

use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;
use Pccomponentes\Ddd\Util\Message\Message;
use Pccomponentes\Ddd\Util\Message\MessageVisitor;

class MessageTested extends Message
{
    private static $messageName;
    private static $messageVersion;
    private static $messageType;

    public static function set(string $name, string $version, string $type): void
    {
        self::$messageName = $name;
        self::$messageVersion = $version;
        self::$messageType = $type;
    }

    public static function test(Uuid $messageId, array $payload): self
    {
        return new self($messageId, $payload);
    }

    public static function messageName(): string
    {
        return self::$messageName;
    }

    public static function messageVersion(): string
    {
        return self::$messageVersion;
    }

    public static function messageType(): string
    {
        return self::$messageType;
    }

    public function accept(MessageVisitor $visitor): void
    {
        //nothing for this case
    }
}
