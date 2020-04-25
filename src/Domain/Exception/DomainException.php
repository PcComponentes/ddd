<?php
declare(strict_types=1);

namespace Pccomponentes\Ddd\Domain\Exception;

abstract class DomainException extends \Exception implements \JsonSerializable
{
}
