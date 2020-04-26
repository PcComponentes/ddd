<?php

declare(strict_types=1);
namespace PcComponentes\Ddd\Tests\Domain\Model\ValueObject;

use PHPUnit\Framework\TestCase;

class BoolValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function given_true_when_ask_to_get_info_then_return_expected_info()
    {
        $bool = BoolValueObjectTested::from(true);
        $this->assertTrue($bool->value());
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
        $this->assertTrue($bool->jsonSerialize());
    }

    /**
     * @test
     */
    public function given_false_when_ask_to_get_info_then_return_expected_info()
    {
        $bool = BoolValueObjectTested::from(false);
        $this->assertFalse($bool->value());
        $this->assertFalse($bool->isTrue());
        $this->assertTrue($bool->isFalse());
        $this->assertFalse($bool->jsonSerialize());
    }
}
