<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Domain\Model\ValueObject;

use PHPUnit\Framework\TestCase;

class EnumValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function given_enum_class_when_ask_to_get_enums_values_then_return_array_of_values()
    {
        $this->assertEquals(['ENUM_1' => '1', 'ENUM_2' => '2'], EnumValueObjectTested::allowedValues());
    }

    /**
     * @test
     */
    public function given_available_value_when_ask_to_get_info_then_return_expected_info()
    {
        $enum = EnumValueObjectTested::from('1');

        $this->assertEquals('1', $enum->value());
        $this->assertEquals('1', $enum->jsonSerialize());
        $enum::allowedValues();
    }

    /**
     * @test
     */
    public function given_two_identical_enums_when_ask_to_check_equality_then_return_true()
    {
        $enum = EnumValueObjectTested::from('1');
        $other = EnumValueObjectTested::from('1');

        $this->assertTrue($enum->equalTo($other));
    }

    /**
     * @test
     */
    public function given_two_different_enums_when_ask_to_check_equality_then_return_false()
    {
        $enum = EnumValueObjectTested::from('1');
        $other = EnumValueObjectTested::from('2');

        $this->assertFalse($enum->equalTo($other));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function given_invalid_enum_value_when_create_enum_then_throw_exception()
    {
        EnumValueObjectTested::from('3');
    }
}
