<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Util\Message;

use Pccomponentes\Ddd\Domain\Model\ValueObject\Uuid;

abstract class Message implements \JsonSerializable
{
    private $messageId;
    private $payload;

    protected function __construct(Uuid $messageId, array $payload)
    {
        $this->assertPrimitivePayload($payload);
        $this->messageId = $messageId;
        $this->payload = $payload;
    }

    public function messageId(): Uuid
    {
        return $this->messageId;
    }

    public function messagePayload(): array
    {
        return $this->payload;
    }

    public function jsonSerialize()
    {
        return [
            'message_id' => $this->messageId(),
            'name' => static::messageName(),
            'version' => static::messageVersion(),
            'type' => static::messageType(),
            'payload' => $this->messagePayload()
        ];
    }

    private function assertPrimitivePayload(array &$payload, string $index = 'payload'): void
    {
        \array_walk(
            $payload,
            function ($item, $currentIndex) use ($index) {
                $newIndex = "{$index}.{$currentIndex}";
                switch (true) {
                    case \is_object($item):
                        throw new \InvalidArgumentException(
                            sprintf(
                                'Attribute %s is an object. Payload parameters only can be primitive.',
                                $newIndex
                            )
                        );
                    case \is_array($item):
                        $this->assertPrimitivePayload($item, $newIndex);
                }
            }
        );
    }

    abstract public static function messageName(): string;
    abstract public static function messageVersion(): string;
    abstract public static function messageType(): string;
}
