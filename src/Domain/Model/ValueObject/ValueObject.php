<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Model\ValueObject;

interface ValueObject extends \JsonSerializable
{
    public function value(): mixed;
}
