<?php declare(strict_types=1);

namespace Pccomponentes\Ddd\Util\Message\Serialization;

final class MessageMappingRegistry
{
    private $registry;

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
