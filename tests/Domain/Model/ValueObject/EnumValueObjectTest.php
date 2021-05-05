<?php

declare(strict_types=1);

namespace PcComponentes\Ddd\Tests\Domain\Model\ValueObject;

use PcComponentes\Ddd\Domain\Model\ValueObject\EnumValueObject;
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
     *
     */
    public function given_invalid_enum_value_when_create_enum_then_throw_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        EnumValueObjectTested::from('3');
    }

    /**
     * @test
     */
    public function given_valid_enum_value_when_exist_a_previous_different_implementation_then_uses_its_own_allowed_values_for_validation(
    )
    {
        new class('FIRST_VALUE_1') extends EnumValueObject {
            private const ENUM_1 = 'FIRST_VALUE_1';
            private const ENUM_2 = 'FIRST_VALUE_2';

            public function __construct($value)
            {
                parent::__construct($value);
            }
        };

        $this->expectException(\InvalidArgumentException::class);
        new class('FIRST_VALUE_1') extends EnumValueObject {
            private const ENUM_1 = 'SUBSEQUENT_VALUE_1';
            private const ENUM_2 = 'SUBSEQUENT_VALUE_2';

            public function __construct($value)
            {
                parent::__construct($value);
            }
        };

        try {
            $validValue = 'SUBSEQUENT_VALUE_1';
            new class($validValue) extends EnumValueObject {
                private const ENUM_1 = 'SUBSEQUENT_VALUE_1';
                private const ENUM_2 = 'SUBSEQUENT_VALUE_2';

                public function __construct($value)
                {
                    parent::__construct($value);
                }
            };
        } catch (\InvalidArgumentException $e) {
            self::fail(sprintf(
                'Failed asserting valid %s argument not in allowed values [%s]',
                $validValue,
                'SUBSEQUENT_VALUE_1, SUBSEQUENT_VALUE_2'
            ));
        }
    }

    /**
     * @test
     */
    public function given_invalid_enum_value_when_throws_exception_then_message_has_enum_subclass_name()
    {
        try {
            new class('FIRST_VALUE_1') extends EnumValueObject {
                private const ENUM_1 = 'SUBSEQUENT_VALUE_1';
                private const ENUM_2 = 'SUBSEQUENT_VALUE_2';

                public function __construct($value)
                {
                    parent::__construct($value);
                }
            };
        } catch (\InvalidArgumentException $e) {
            self::assertStringMatchesFormat('%s@anonymous%s', $e->getMessage());
        }
    }
}
