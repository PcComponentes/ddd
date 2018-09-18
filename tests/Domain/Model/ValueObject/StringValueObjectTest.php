<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Domain\Model\ValueObject;

use PHPUnit\Framework\TestCase;

class StringValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function given_string_value_when_ask_to_get_info_then_return_expected_info()
    {
        $str = StringValueObjectTested::from('tonto el que lo lea');

        $this->assertEquals('tonto el que lo lea', $str->value());
        $this->assertEquals('tonto el que lo lea', $str->jsonSerialize());
    }

    /**
     * @test
     */
    public function given_two_identical_strings_when_ask_to_check_equality_then_return_true()
    {
        $str = StringValueObjectTested::from('tonto el que lo lea');
        $other = StringValueObjectTested::from('tonto el que lo lea');

        $this->assertTrue($str->equalTo($other));
    }

    /**
     * @test
     */
    public function given_two_different_strings_when_ask_to_check_equality_then_return_false()
    {
        $str = StringValueObjectTested::from('tonto el que lo lea');
        $other = StringValueObjectTested::from('EMOSIDO ENGAÑADO');

        $this->assertFalse($str->equalTo($other));
    }
}
