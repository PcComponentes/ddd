<?php

declare(strict_types=1);

namespace PcComponentes\Ddd\Tests\Domain\Model\ValueObject;

use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    /**
     * @test
     */
    public function given_uuid_value_when_ask_to_get_info_then_return_expected_info()
    {
        $str = Uuid::from('f25144ac-2ce2-4b14-9d90-494b89fc09e2');

        $this->assertEquals('f25144ac-2ce2-4b14-9d90-494b89fc09e2', $str->value());
        $this->assertEquals('f25144ac-2ce2-4b14-9d90-494b89fc09e2', $str->jsonSerialize());
    }

    /**
     * @test
     */
    public function given_uuid_class_when_ask_to_generate_an_uuid_v4_then_return_uuid_instance()
    {
        $uuid = Uuid::v4();
        $this->assertInstanceOf(Uuid::class, $uuid);
        $this->assertMatchesRegularExpression('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $uuid->value());
    }

    /**
     * @test
     */
    public function given_two_identical_uuids_when_ask_to_check_equality_then_return_true()
    {
        $str = Uuid::from('f25144ac-2ce2-4b14-9d90-494b89fc09e2');
        $other = Uuid::from('f25144ac-2ce2-4b14-9d90-494b89fc09e2');

        $this->assertTrue($str->equalTo($other));
    }

    /**
     * @test
     */
    public function given_two_different_uuids_when_ask_to_check_equality_then_return_false()
    {
        $str = Uuid::from('f25144ac-2ce2-4b14-9d90-494b89fc09e2');
        $other = Uuid::from('0561473c-a44d-49e0-98ea-90368790de09');

        $this->assertFalse($str->equalTo($other));
    }

    /**
     * @test
     */
    public function given_invalid_uuid_when_ask_to_get_info_then_throw_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        Uuid::from('non-uuid');
    }
}
