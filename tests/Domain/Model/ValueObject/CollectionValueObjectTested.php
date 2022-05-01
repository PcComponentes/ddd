<?php

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

    public function firstItem()
    {
        return $this->first();
    }
}
