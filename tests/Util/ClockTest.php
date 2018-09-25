<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Util;

use Pccomponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use Pccomponentes\Ddd\Util\Clock;
use PHPUnit\Framework\TestCase;

class ClockTest extends TestCase
{
    /**
     * @test
     */
    public function given_date_string_when_ask_to_create_date_then_return_date_instance()
    {
        $dateStr = '2018-01-01 12:12:12';
        $date = Clock::from($dateStr);
        $this->assertEquals($dateStr, $date->format('Y-m-d H:i:s'));
        $this->assertEquals('UTC', $date->getTimezone()->getName());
    }

    /**
     * @test
     */
    public function given_nothig_when_ask_to_create_date_now_then_return_date_instance()
    {
        $expectedNow = new \DateTimeImmutable('now');
        $dateNow = Clock::now();

        $this->assertEquals($expectedNow->getTimestamp(), $dateNow->getTimestamp());
    }

    /**
     * @test
     */
    public function given_fake_date_when_ask_to_create_date_now_then_return_fake_date_instance()
    {
        $expectedNow = DateTimeValueObject::from('2018-01-01 00:00:00');
        Clock::fakeNow($expectedNow);
        $dateNow = Clock::now();

        $this->assertSame($expectedNow, $dateNow);
    }
}
