<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Domain\Model\ValueObject;

use Pccomponentes\Ddd\Domain\Model\ValueObject\DateTimeValueObject;
use PHPUnit\Framework\TestCase;

class DateTimeValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function given_date_when_ask_to_get_info_then_return_expected_info()
    {
        $datetime = DateTimeValueObject::from('2000-01-02 03:04:05');
        $this->assertEquals('2000-01-02T03:04:05+00:00', $datetime->jsonSerialize());
    }
}
