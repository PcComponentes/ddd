<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Tests\Domain\Model\ValueObject;

use PcComponentes\Ddd\Domain\Model\ValueObject\DateValueObject;
use PHPUnit\Framework\TestCase;

final class DateValueObjectTest extends TestCase
{
    /** @test */
    public function given_date_when_check_value_then_return_right_value(): void
    {
        $expectedValue = '2023-07-06';
        $date = DateValueObject::from('2023-07-06');
        $this->assertSame($expectedValue, $date->value());
        $this->assertSame($expectedValue, $date->jsonSerialize());
    }

    /** @test */
    public function given_date_from_now_when_check_value_then_return_right_value(): void
    {
        $date = DateValueObject::now();
        $this->assertSame(
            (new \DateTimeImmutable('now'))->format('Y-m-d'),
            $date->value()
        );
    }
}
