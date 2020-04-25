<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Exception;

abstract class AggregateException extends DomainException
{
    abstract public function id(): string;

    abstract public function resource(): string;
  
    final public function jsonSerialize(): array
    {
        return [
            'id' => $this->id(),
            'resource' => $this->resource(),
        ];
    }
}
