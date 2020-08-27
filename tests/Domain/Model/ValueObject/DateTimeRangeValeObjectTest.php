<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Tests\Domain\Model\ValueObject;

use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeRangeValeObject;
use PcComponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use PHPUnit\Framework\TestCase;

final class DateTimeRangeValeObjectTest extends TestCase
{
    /** @test */
    public function given_valid_range_when_ask_to_get_info_then_return_expected_info(): void
    {
        $range = DateTimeRangeValeObject::from(
            DateTimeValueObject::from('2000-01-01 00:00:00'),
            DateTimeValueObject::from('2019-12-31 23:59:59'),
        );

        $this->assertEquals(DateTimeValueObject::from('2000-01-01 00:00:00'), $range->start());
        $this->assertEquals(DateTimeValueObject::from('2019-12-31 23:59:59'), $range->end());
    }

    /** @test */
    public function given_invalid_range_when_creating_range_then_throw_exception(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        DateTimeRangeValeObject::from(
            DateTimeValueObject::from('2019-12-31 23:59:59'),
            DateTimeValueObject::from('2000-01-01 00:00:00'),
        );
    }

    /** @test */
    public function given_equal_dates_when_creating_range_then_throw_exception(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        DateTimeRangeValeObject::from(
            DateTimeValueObject::from('2000-01-01 00:00:00'),
            DateTimeValueObject::from('2000-01-01 00:00:00'),
        );
    }

    /** @test */
    public function given_expired_range_when_ask_if_expired_then_return_expected_info(): void
    {
        $range = DateTimeRangeValeObject::from(
            DateTimeValueObject::from('2000-01-01 00:00:00'),
            DateTimeValueObject::from('2001-12-31 23:59:59'),
        );

        $this->assertFalse($range->isInDate());
        $this->assertTrue($range->isExpired());
        $this->assertFalse($range->isNotStarted());
    }

    /** @test */
    public function given_in_date_range_when_ask_if_in_date_then_return_expected_info(): void
    {
        $range = DateTimeRangeValeObject::from(
            DateTimeValueObject::from('2020-01-01 00:00:00'),
            DateTimeValueObject::from('2100-12-31 23:59:59'),
        );

        $this->assertTrue($range->isInDate());
        $this->assertFalse($range->isExpired());
        $this->assertFalse($range->isNotStarted());
    }

    /** @test */
    public function given_not_started_range_when_ask_if_not_started_then_return_expected_info(): void
    {
        $range = DateTimeRangeValeObject::from(
            DateTimeValueObject::from('2050-01-01 00:00:00'),
            DateTimeValueObject::from('2100-12-31 23:59:59'),
        );

        $this->assertFalse($range->isInDate());
        $this->assertFalse($range->isExpired());
        $this->assertTrue($range->isNotStarted());
    }

    /** @test */
    public function given_two_equal_ranges_when_ask_to_check_equality_then_return_true(): void
    {
        $range = DateTimeRangeValeObject::from(
            DateTimeValueObject::from('2000-01-01 00:00:00'),
            DateTimeValueObject::from('2019-12-31 23:59:59'),
        );

        $other = DateTimeRangeValeObject::from(
            DateTimeValueObject::from('2000-01-01 00:00:00'),
            DateTimeValueObject::from('2019-12-31 23:59:59'),
        );

        $this->assertTrue($range->equalTo($other));
    }

    /** @test */
    public function given_two_different_ranges_when_ask_to_check_equality_then_return_false(): void
    {
        $range = DateTimeRangeValeObject::from(
            DateTimeValueObject::from('2000-01-01 00:00:00'),
            DateTimeValueObject::from('2019-12-31 23:59:59'),
        );

        $other = DateTimeRangeValeObject::from(
            DateTimeValueObject::from('2000-01-01 00:00:01'),
            DateTimeValueObject::from('2019-12-31 23:59:59'),
        );

        $this->assertFalse($range->equalTo($other));
    }
}
