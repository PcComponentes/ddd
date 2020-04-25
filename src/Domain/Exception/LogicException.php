<?php
declare(strict_types=1);

namespace Pccomponentes\Ddd\Domain\Exception;

abstract class LogicException extends DomainException
{
    public abstract function data(): array;

    final public function jsonSerialize(): array
    {
        return $this->data();
    }
}
