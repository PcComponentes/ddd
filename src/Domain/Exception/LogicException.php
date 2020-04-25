<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Exception;

abstract class LogicException extends DomainException
{
    abstract public function data(): array;

    final public function jsonSerialize(): array
    {
        return $this->data();
    }
}
