<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Tests\Domain\Model\ValueObject;

final class ObjectMock
{
    public function __construct(private int $a, private string $b)
    {
    }

    public function a(): int
    {
        return $this->a;
    }

    public function b(): string
    {
        return $this->b;
    }
}
