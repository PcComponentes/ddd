<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <jgrodriguezcarrion@gmail.com>
 */
declare(strict_types=1);
namespace Pccomponentes\Ddd\Tests\Aplication;

use Pccomponentes\Ddd\Application\Query;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    /**
     * @test
     */
    public function given_query_when_ask_to_get_type_then_return_expected_info()
    {
        $this->assertEquals('query', Query::messageType());
    }
}
