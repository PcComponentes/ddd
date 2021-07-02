<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Tests\Domain\Model\ValueObject;

use PcComponentes\Ddd\Domain\Model\ValueObject\CollectionValueObject;
use PcComponentes\Ddd\Domain\Model\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class CollectionValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function given_empty_collection_when_ask_to_get_info_then_return_expected_info()
    {
        $collection = CollectionValueObject::from([]);

        $this->assertEquals([], $collection->jsonSerialize());
        $this->assertTrue($collection->isEmpty());
    }

    /**
     * @test
     */
    public function given_collection_when_ask_to_get_info_then_return_expected_info()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);

        $this->assertEquals([1, 2, 3, 4], $collection->jsonSerialize());
        $this->assertFalse($collection->isEmpty());
    }

    /**
     * @test
     */
    public function given_collection_when_ask_to_reduce_then_return_expected_info()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $reduced = $collection->reduce(
            function ($carry, $current) {
                return $carry . $current;
            },
            ''
        );

        $this->assertEquals('1234', $reduced);
    }

    /**
     * @test
     */
    public function given_integerish_collection_when_ask_to_sort_then_return_new_sorted_collection()
    {
        $collection = CollectionValueObject::from([5, 1, 4, 2, 3]);
        $sorted = $collection->sort(
            function ($a, $b) {
               return $a - $b;
            }
        );

        $this->assertEquals([5, 1, 4, 2, 3], $collection->jsonSerialize());
        $this->assertEquals([1, 2, 3, 4, 5], $sorted->jsonSerialize());
    }

    /**
     * @test
     */
    public function given_collection_when_ask_to_sort_then_return_new_sorted_collection()
    {
        $collection = CollectionValueObject::from(['5a', '1', '4', '2', '3']);
        $sorted = $collection->sort(
            function ($a, $b) {
                if ($a == $b) {
                    return 0;
                }
                return ($a < $b) ? -1 : 1;
            }
        );

        $this->assertEquals(['5a', '1', '4', '2', '3'], $collection->jsonSerialize());
        $this->assertEquals(['1', '2', '3', '4', '5a'], $sorted->jsonSerialize());
    }

    /**
     * @test
     */
    public function given_collection_when_ask_to_filter_then_return_expected_info()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $newCollection = $collection->filter(
            function ($current) {
                return 2 !== $current;
            }
        );

        $this->assertEquals([1, 3, 4], $newCollection->jsonSerialize());
    }

    /**
     * @test
     */
    public function given_collection_when_ask_to_walk_then_iterate_for_all_items()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $iterated = [];
        $collection->walk(
            function ($current) use (&$iterated) {
                $iterated[] = $current;
            }
        );

        $this->assertEquals([1, 2, 3, 4], $iterated);
    }

    /**
     * @test
     */
    public function given_two_identical_collections_when_ask_to_check_equality_then_return_true()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $other = CollectionValueObject::from([1, 2, 3, 4]);

        $this->assertTrue($collection->equalTo($other));
    }

    /**
     * @test
     */
    public function given_two_different_collections_when_ask_to_check_equality_then_return_false()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $other = CollectionValueObject::from([5, 6, 7, 8]);

        $this->assertFalse($collection->equalTo($other));
    }

    /**
     * @test
     */
    public function given_collection_when_ask_to_add_item_then_return_new_collection()
    {
        $collection = CollectionValueObjectTested::from([1, 2, 3, 4]);
        $newCollection = $collection->add(5);

        $this->assertEquals([1, 2, 3, 4], $collection->jsonSerialize());
        $this->assertEquals([1, 2, 3, 4, 5], $newCollection->jsonSerialize());
    }

    /**
     * @test
     */
    public function given_collection_when_ask_to_remove_item_then_return_new_collection()
    {
        $collection = CollectionValueObjectTested::from([1, 2, 3, 4]);
        $newCollection = $collection->remove(3);

        $this->assertEquals([1, 2, 3, 4], $collection->jsonSerialize());
        $this->assertEquals([1, 2, 4], $newCollection->jsonSerialize());
    }

    /**
     * @test
     */
    public function given_an_empty_collection_when_ask_to_obtain_first_item_then_return_null()
    {
        $collection = CollectionValueObjectTested::from([]);
        $item = $collection->firstItem();

        $this->assertEquals(null, $item);
    }

    /**
     * @test
     */
    public function given_a_hash_map_collection_when_ask_to_obtain_first_item_then_return_first_item()
    {
        $firstItem = 1;
        $collection = CollectionValueObjectTested::from(['a' => $firstItem, 'b' => 2, 'c' => 3, 'd' => 4]);
        $item = $collection->firstItem();

        $this->assertEquals(['a' => $firstItem, 'b' => 2, 'c' => 3, 'd' => 4], $collection->jsonSerialize());
        $this->assertEquals($firstItem, $item);
    }

    /**
     * @test
     */
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

    /**
     * @test
     */
    public function given_two_different_collections_when_ask_to_have_same_values_then_return_false()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $other = CollectionValueObject::from([5, 6, 7, 8]);

        $this->assertFalse($collection->haveSameValues($other));
    }

    /**
     * @test
     */
    public function given_two_different_collections_when_one_contains_the_other_and_ask_to_have_same_values_then_return_false()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $other = CollectionValueObject::from([1, 2, 3, 4, 5]);

        $this->assertFalse($collection->haveSameValues($other));
    }

    /**
     * @test
     */
    public function given_two_unordered_equals_collections_when_ask_to_have_same_values_then_return_true()
    {
        $collection = CollectionValueObject::from([1, 1, 3, 4]);
        $other = CollectionValueObject::from([4, 1, 3, 1]);

        $this->assertTrue($collection->haveSameValues($other));
    }

    /**
     * @test
     */
    public function given_two_ordered_equals_collections_when_ask_to_have_same_values_then_return_true()
    {
        $collection = CollectionValueObject::from([1, 2, 3, 4]);
        $other = CollectionValueObject::from([1, 2, 3, 4]);

        $this->assertTrue($collection->haveSameValues($other));
    }

    /**
     * @test
     */
    public function given_two_ordered_equals_hashed_collections_when_ask_to_have_same_values_then_return_true()
    {
        $collection = CollectionValueObject::from(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]);
        $other = CollectionValueObject::from(['b' => 1, 'a' => 2, 'd' => 3, 'c' => 4]);

        $this->assertTrue($collection->haveSameValues($other));
    }

    /**
     * @test
     */
    public function given_two_unordered_equals_hashed_collections_when_ask_to_have_same_values_then_return_true()
    {
        $collection = CollectionValueObject::from(['a' => 2, 'b' => 1, 'c' => 3, 'd' => 4]);
        $other = CollectionValueObject::from(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]);

        $this->assertTrue($collection->haveSameValues($other));
    }

    /**
     * @test
     */
    public function given_two_unordered_different_hashed_collections_when_ask_to_have_same_values_then_return_false()
    {
        $collection = CollectionValueObject::from(['a' => 1, 'b' => 3, 'c' => 3, 'd' => 4]);
        $other = CollectionValueObject::from(['b' => 1, 'a' => 2, 'd' => 3, 'c' => 4]);

        $this->assertFalse($collection->haveSameValues($other));
    }

    /**
     * @test
     */
    public function given_two_unordered_equals_object_collections_when_ask_to_have_same_values_then_return_false()
    {
        $uuid1 = new \stdClass();
        $uuid2 = new \stdClass();
        $uuid3 = new \stdClass();
        $uuid4 = new \stdClass();
        $uuid1->id = Uuid::v4();
        $uuid2->id = Uuid::v4();
        $uuid3->id = Uuid::v4();
        $uuid4->id = Uuid::v4();


        $collection = CollectionValueObject::from([$uuid1, $uuid2, $uuid3, $uuid4]);
        $other = CollectionValueObject::from([$uuid1, $uuid3, $uuid4, $uuid2]);

        $this->assertTrue($collection->haveSameValues($other));
    }

    /**
     * @test
     */
    public function given_two_unordered_different_object_collections_when_ask_to_have_same_values_then_return_false()
    {
        $uuid1 = new \stdClass();
        $uuid2 = new \stdClass();
        $uuid3 = new \stdClass();
        $uuid4 = new \stdClass();
        $uuid5 = new \stdClass();
        $uuid1->id = Uuid::v4();
        $uuid2->id = Uuid::v4();
        $uuid3->id = Uuid::v4();
        $uuid4->id = Uuid::v4();
        $uuid5->id = Uuid::v4();

        $collection = CollectionValueObject::from([$uuid1, $uuid5, $uuid3, $uuid4]);
        $other = CollectionValueObject::from([$uuid1, $uuid3, $uuid4, $uuid2]);

        $this->assertFalse($collection->haveSameValues($other));
    }
}
