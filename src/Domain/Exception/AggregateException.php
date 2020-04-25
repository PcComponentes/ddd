<?php
declare(strict_types=1);

namespace Pccomponentes\Ddd\Domain\Exception;

abstract class AggregateException extends DomainException
{
    public abstract function id(): string;
    public abstract function resource(): string;
  
    final public function jsonSerialize(): array
    {
        return  [
            'id' => $this->id(),
            'resource' => $this->resource(),
        ];
    }
}
