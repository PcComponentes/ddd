<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util\Message\Serialization;

final class MessageMappingRegistry
{
    private array $registry;

    public function __construct(array $registry)
    {
        $this->registry = $registry;
    }

    public function __invoke(string $messageName): ?string
    {
        if (\array_key_exists($messageName, $this->registry)) {
            return $this->registry[$messageName];
        }

        return null;
    }
}
