<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util\Message\Serialization\JsonApi;

final class SimpleMessageStream
{
    private string $messageId;
    private string $messageName;
    private string $payload;

    public function __construct(string $messageId, string $messageName, string $payload)
    {
        $this->messageId = $messageId;
        $this->messageName = $messageName;
        $this->payload = $payload;
    }

    public function messageId(): string
    {
        return $this->messageId;
    }

    public function messageName(): string
    {
        return $this->messageName;
    }

    public function payload(): string
    {
        return $this->payload;
    }
}
