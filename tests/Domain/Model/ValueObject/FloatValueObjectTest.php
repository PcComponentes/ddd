<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Domain\Model\ValueObject;

use PHPUnit\Framework\TestCase;

class FloatValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function given_float_value_when_ask_to_get_info_then_return_expected_info_blasdlasldasldlasdlasdlasdlasldasldlasdlas()
    {
        $float = FloatValueObjectTested::from(\M_PI);

        $this->assertEquals(\M_PI, $float->value());
        $this->assertEquals(\M_PI, $float->jsonSerialize());
    }

    /**
     * @test
     */
    public function given_two_identical_floats_when_ask_to_check_equality_then_return_true()
    {
        $float = FloatValueObjectTested::from(\M_PI);
        $other = FloatValueObjectTested::from(\M_PI);

        $this->assertTrue($float->equalTo($other));
    }

    /**
     * @test
     */
    public function given_two_different_floats_when_ask_to_check_equality_then_return_false()
    {
        $float = FloatValueObjectTested::from(\M_PI);
        $other = FloatValueObjectTested::from(\M_PI_2);

        $this->assertFalse($float->equalTo($other));
    }
}
