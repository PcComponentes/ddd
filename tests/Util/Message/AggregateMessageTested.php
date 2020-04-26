<?php

declare(strict_types=1);
namespace PcComponentes\Ddd\Tests\Util\Message;

use PcComponentes\Ddd\Util\Message\AggregateMessage;

class AggregateMessageTested extends AggregateMessage
{
    private static $messageName;
    private static $messageVersion;
    private static $messageType;
    private $assertPayloadCalled;

    public static function set(string $name, string $version, string $type): void
    {
        self::$messageName = $name;
        self::$messageVersion = $version;
        self::$messageType = $type;
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

    protected function assertPayload(): void
    {
        $this->assertPayloadCalled = true;
    }

    public function assertPayloadCalled(): bool
    {
        return $this->assertPayloadCalled ?? false;
    }
}
