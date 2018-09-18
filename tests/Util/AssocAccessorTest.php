<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Util;

use Pccomponentes\Ddd\Util\AssocAccessor;
use PHPUnit\Framework\TestCase;

class AssocAccessorTest extends TestCase
{
    /**
     * @test
     */
    public function given_array_when_ask_to_take_an_available_index_value_or_exception_then_return_it()
    {
        $this->assertEquals(1234, AssocAccessor::get(['test' => 1234], 'test'));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function given_array_when_ask_to_take_an_unavailable_index_value_or_exception_then_throw_exception()
    {
        AssocAccessor::get(['test' => 1234], 'other');
    }

    /**
     * @test
     */
    public function given_array_when_ask_to_take_an_available_advanced_index_value_or_exception_then_return_it()
    {
        $data = [
            'test' => [
                'other' => [9, 8, 7]
            ]
        ];

        $this->assertEquals(8, AssocAccessor::get($data, 'test.other.1'));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function given_array_when_ask_to_take_an_unavailable_advanced_index_value_or_exception_then_return_it()
    {
        $data = [
            'test' => [
                'other' => [9, 8, 7]
            ]
        ];

        AssocAccessor::get($data, 'test.other.3');
    }

    /**
     * @test
     */
    public function given_array_when_ask_to_take_an_available_index_value_or_default_then_return_it()
    {
        $this->assertEquals(1234, AssocAccessor::getOrDefault(['test' => 1234], 'test', 0));
    }

    /**
     * @test
     */
    public function given_array_when_ask_to_take_an_unavailable_index_value_or_default_then_return_default()
    {
        $this->assertEquals(0, AssocAccessor::getOrDefault(['other' => 1234], 'test', 0));
    }

    /**
     * @test
     */
    public function given_array_when_ask_to_take_an_available_advanced_index_value_or_default_then_return_it()
    {
        $data = [
            'test' => [
                'other' => [9, 8, 7]
            ]
        ];

        $this->assertEquals(8, AssocAccessor::getOrDefault($data, 'test.other.1', 0));
    }

    /**
     * @test
     */
    public function given_array_when_ask_to_take_an_unavailable_advanced_index_value_or_default_then_return_default()
    {
        $data = [
            'test' => [
                'other' => [9, 8, 7]
            ]
        ];

        $this->assertEquals(0, AssocAccessor::getOrDefault($data, 'test.other.3', 0));
    }
}
