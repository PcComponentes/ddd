<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Util\Message;

use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;
use Pccomponentes\Ddd\Util\Message\Message;

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
}
