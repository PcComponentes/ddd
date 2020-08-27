<?php

namespace PcComponentes\Ddd\Tests\Domain\Model;

use PcComponentes\Ddd\Domain\Model\SimpleAggregateRoot;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class SimpleAggregateRootTest extends TestCase
{
    /** @test */
    public function given_simple_aggregate_root_when_create_then_return_created_events()
    {
        $aggregateId = Uuid::from('41cd9629-d379-426b-8167-ea5f56d4d2c6');
        $test = SimpleAggregateRootTested::test($aggregateId);

        self::assertEquals($aggregateId, $test->aggregateId());
        self::assertCount(1, $test->events());
        self::assertInstanceOf(DomainEventTested::class, $test->events()[0]);
    }
}
