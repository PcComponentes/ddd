<?php

declare(strict_types=1);

namespace PcComponentes\Ddd\Tests\Domain\Model\ValueObject;

use PcComponentes\Ddd\Domain\Model\ValueObject\UniqueId;
use PHPUnit\Framework\TestCase;

class UniqueIdTest extends TestCase
{
    /**
     * @test
     */
    public function given_uid_value_when_ask_to_get_info_then_return_expected_info()
    {
        $value = 'H7HVQ2U72X';
        $str = UniqueId::from($value);

        $this->assertEquals($value, $str->value());
        $this->assertEquals($value, $str->jsonSerialize());
    }

    /**
     * @test
     */
    public function given_uid_class_when_ask_to_generate_an_uid_then_return_uid_instance()
    {
        $uid = UniqueId::create();
        $this->assertInstanceOf(UniqueId::class, $uid);
        $this->assertMatchesRegularExpression('/^[0-9A-Z]{10}$/i', $uid->value());
    }

    /**
     * @test
     */
    public function given_two_identical_uids_when_ask_to_check_equality_then_return_true()
    {
        $value = 'H7HVQ2U72X';
        $str = UniqueId::from($value);
        $other = UniqueId::from($value);

        $this->assertTrue($str->equalTo($other));
    }

    /**
     * @test
     */
    public function given_two_different_uids_when_ask_to_check_equality_then_return_false()
    {
        $str = UniqueId::from('H7HVQ2U72X');
        $other = UniqueId::from('H7INVWHVPR');

        $this->assertFalse($str->equalTo($other));
    }
}
