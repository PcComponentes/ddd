<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Domain\Model\ValueObject;

use PHPUnit\Framework\TestCase;

class IntValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function given_integer_value_when_ask_to_get_info_then_return_expected_info()
    {
        $int = IntValueObjectTested::from(42);

        $this->assertEquals(42, $int->value());
        $this->assertEquals(42, $int->jsonSerialize());
    }

    /**
     * @test
     */
    public function given_two_identical_integers_when_ask_to_check_equality_then_return_true()
    {
        $int = IntValueObjectTested::from(42);
        $other = IntValueObjectTested::from(42);

        $this->assertTrue($int->equalTo($other));
    }

    /**
     * @test
     */
    public function given_two_different_integers_when_ask_to_check_equality_then_return_false()
    {
        $int = IntValueObjectTested::from(42);
        $other = IntValueObjectTested::from(69);

        $this->assertFalse($int->equalTo($other));
    }
}
