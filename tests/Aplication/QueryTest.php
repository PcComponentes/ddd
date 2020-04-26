<?php
/**
 * This disaster was designed by
 * @author Juan G. Rodríguez Carrión <juan.rodriguez@pccomponentes.com>
 */
declare(strict_types=1);
namespace PcComponentes\Ddd\Tests\Aplication;

use PcComponentes\Ddd\Application\Query;
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
