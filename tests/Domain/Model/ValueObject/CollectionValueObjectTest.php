<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Tests\Domain\Model\ValueObject;

use PcComponentes\Ddd\Domain\Model\ValueObject\CollectionValueObject;
use PHPUnit\Framework\TestCase;

class CollectionValueObjectTest extends TestCase
{
    /** @test */
    public function given_empty_collection_when_ask_to_get_info_then_return_expected_info()
    {
        $collection = CollectionValueObject::from([]);

        $this->assertEquals([], $collection->jsonSerialize());
        $this->assertTrue($collection->isEmpty());
    }

    /** @test */
    public function given_collection_when_ask_to_get_info_then_return_expected_info()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);

        $this->assertEquals([1, 2, 3, 4], $collection->jsonSerialize());
        $this->assertFalse($collection->isEmpty());
    }

    /** @test */
    public function given_collection_when_ask_to_reduce_then_return_expected_info()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $reduced = $collection->reduce(
            static fn ($carry, $current) => $carry . $current,
            '',
        );

        $this->assertEquals('1234', $reduced);
    }

    /** @test */
    public function given_integerish_collection_when_ask_to_sort_then_return_new_sorted_collection()
    {
        $collection = CollectionValueObject::from([5, 1, 4, 2, 3]);
        $sorted = $collection->sort(
            static fn ($a, $b) => $a - $b,
        );

        $this->assertEquals([5, 1, 4, 2, 3], $collection->jsonSerialize());
        $this->assertEquals([1, 2, 3, 4, 5], $sorted->jsonSerialize());
    }

    /** @test */
    public function given_collection_when_ask_to_sort_then_return_new_sorted_collection()
    {
        $collection = CollectionValueObject::from(['5a', '1', '4', '2', '3']);
        $sorted = $collection->sort(
            static function ($a, $b) {
                if ($a == $b) {
                    return 0;
                }

                return $a < $b
                    ? -1
                    : 1;
            },
        );

        $this->assertEquals(['5a', '1', '4', '2', '3'], $collection->jsonSerialize());
        $this->assertEquals(['1', '2', '3', '4', '5a'], $sorted->jsonSerialize());
    }

    /** @test */
    public function given_collection_when_ask_to_filter_then_return_expected_info()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $newCollection = $collection->filter(
            static fn ($current) => 2 !== $current,
        );

        $this->assertEquals([1, 3, 4], $newCollection->jsonSerialize());
    }

    /** @test */
    public function given_collection_when_ask_to_walk_then_iterate_for_all_items()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $iterated = [];
        $collection->walk(
            static function ($current) use (&$iterated) {
                $iterated[] = $current;
            },
        );

        $this->assertEquals([1, 2, 3, 4], $iterated);
    }

    /** @test */
    public function given_two_identical_collections_when_ask_to_check_equality_then_return_true()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $other = CollectionValueObject::from([1, 2, 3, 4]);

        $this->assertTrue($collection->equalTo($other));
    }

    /** @test */
    public function given_two_different_collections_when_ask_to_check_equality_then_return_false()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $other = CollectionValueObject::from([5, 6, 7, 8]);

        $this->assertFalse($collection->equalTo($other));
    }

    public function equivalentCollectionValues(): array
    {
        $objet1 = new ObjectMock(2, 'paodpada');
        $objet2 = new ObjectMock(19, 'adsdaadsads');

        return [
            [[1, 2, 3, 4], [1, 2, 3, 4]],
            [[1, 2, 3, 4], [4, 3, 2, 1]],
            [[1, 2, 3, 4], [1, 2, 4, 3]],
            [[1, 2, 3, 4], [4, 3, 1, 2]],
            [['1', '2', '3', '4'], ['4', '3', '1', '2']],
            [['1', '2', '3', '4'], ['1', '2', '4', '3']],
            [['1', '2', '3', '4'], ['4', '3', '1', '2']],
            [['1', '1', '1', '4'], ['4', '1', '1', '1']],
            [
                [
                    FloatValueObjectTested::from(1.1),
                    FloatValueObjectTested::from(6.0),
                ],
                [
                    FloatValueObjectTested::from(1.1),
                    FloatValueObjectTested::from(6.0),
                ],
            ],
            [[$objet1, $objet2], [$objet1, $objet2]],
            [[$objet1, $objet2], [$objet2, $objet1]],
            [[$objet1, $objet1, $objet2], [$objet1, $objet2, $objet1]],
        ];
    }

    /**
     * @test
     * @dataProvider equivalentCollectionValues
     */
    public function given_two_equivalent_collections_when_ask_to_check_equivalency_then_return_true(
        array $collection,
        array $other,
    ) {
        $collection = CollectionValueObject::from($collection);
        $other = CollectionValueObject::from($other);

        $this->assertTrue($collection->equivalentTo($other));
    }

    public function differentCollectionValues(): array
    {
        return [
            [[1, 2, 3, 4], [1, 2, 3, 5]],
            [[1, 2, 3, 4], [5, 3, 2, 1]],
            [[1, 2, 3, 4], [1, 2, 5, 3]],
            [[1, 2, 3, 4], [5, 3, 1, 2]],
            [['1', '2', '3', '4'], ['5', '3', '1', '2']],
            [['1', '2', '3', '4'], ['1', '2', '5', '3']],
            [['1', '2', '3', '4'], ['5', '3', '1', '2']],
            [['1', '1', '4', '4'], ['4', '1', '1', '1']],
            [
                [
                    FloatValueObjectTested::from(1.1),
                    FloatValueObjectTested::from(6.0),
                ],
                [
                    FloatValueObjectTested::from(1.3),
                    FloatValueObjectTested::from(6.0),
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider differentCollectionValues
     */
    public function given_two_different_collections_when_ask_to_check_equivalency_then_return_false(
        array $collection,
        array $other,
    ) {
        $collection = CollectionValueObject::from($collection);
        $other = CollectionValueObject::from($other);

        $this->assertFalse($collection->equivalentTo($other));
    }

    /** @test */
    public function given_collection_when_ask_to_add_item_then_return_new_collection()
    {
        $collection = CollectionValueObjectTested::from([1, 2, 3, 4]);
        $newCollection = $collection->add(5);

        $this->assertEquals([1, 2, 3, 4], $collection->jsonSerialize());
        $this->assertEquals([1, 2, 3, 4, 5], $newCollection->jsonSerialize());
    }

    /** @test */
    public function given_collection_when_ask_to_remove_item_then_return_new_collection()
    {
        $collection = CollectionValueObjectTested::from([1, 2, 3, 4]);
        $newCollection = $collection->remove(3);

        $this->assertEquals([1, 2, 3, 4], $collection->jsonSerialize());
        $this->assertEquals([1, 2, 4], $newCollection->jsonSerialize());
    }

    /** @test */
    public function given_an_empty_collection_when_ask_to_obtain_first_item_then_return_null()
    {
        $collection = CollectionValueObjectTested::from([]);
        $item = $collection->firstItem();

        $this->assertEquals(null, $item);
    }

    /** @test */
    public function given_a_hash_map_collection_when_ask_to_obtain_first_item_then_return_first_item()
    {
        $firstItem = 1;
        $collection = CollectionValueObjectTested::from(['a' => $firstItem, 'b' => 2, 'c' => 3, 'd' => 4]);
        $item = $collection->firstItem();

        $this->assertEquals(['a' => $firstItem, 'b' => 2, 'c' => 3, 'd' => 4], $collection->jsonSerialize());
        $this->assertEquals($firstItem, $item);
    }

    /** @test */
    public function given_a_collection_when_ask_to_obtain_first_item_then_return_first_item()
    {
        $firstItem = 1;
        $collection = CollectionValueObjectTested::from([$firstItem, 2, 3, 4]);
        $item = $collection->firstItem();

        $this->assertEquals([$firstItem, 2, 3, 4], $collection->jsonSerialize());
        $this->assertEquals($firstItem, $item);
        $this->assertNotEquals(2, $item);
        $this->assertNotEquals(3, $item);
        $this->assertNotEquals(4, $item);
    }
}
