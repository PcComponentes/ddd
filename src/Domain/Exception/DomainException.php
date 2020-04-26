<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Domain\Exception;

abstract class DomainException extends \Exception implements \JsonSerializable
{
}
