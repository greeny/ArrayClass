<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class ChunkTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[1,2,3,4,5,6],
			[1,2,3,4,5,6,7,8,9],
			[],
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_chunk($array, 1, TRUE),
				array_chunk($array, 2, TRUE),
				array_chunk($array, 2, FALSE),
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testChunk($array, $array1, $array2, $array3)
	{
		Assert::same($array1, ArrayClass::from($array)->chunk(1, TRUE)->toArray());
		Assert::same($array2, ArrayClass::from($array)->chunk(2, TRUE)->toArray());
		Assert::same($array3, ArrayClass::from($array)->chunk(2, FALSE)->toArray());
	}

}

testCase(new ChunkTestCase);
