<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace PcComponentes\Ddd\Tests\Domain\Model\ValueObject;

use PcComponentes\Ddd\Domain\Model\ValueObject\CollectionValueObject;

class CollectionValueObjectTested extends CollectionValueObject
{
    public function add($item)
    {
        return $this->addItem($item);
    }

    public function remove($item)
    {
        return $this->removeItem($item);
    }
}
