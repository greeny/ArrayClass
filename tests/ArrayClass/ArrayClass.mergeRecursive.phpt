<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class MergeRecursiveTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[5, 3, 4],
			['b' => 5, 'a' => [1, 2, 3], 'c' => 4],
		];

		$mergeArrays = [
			[
				[1, 2, 3],
				['a' => [4, 2, 3], 'b' => 2, 'c' => 3],
			]
		];

		foreach ($arrays as $array) {
			foreach ($mergeArrays as $merge) {
				yield [
					$array,
					array_merge_recursive($array, $merge),
					$merge,
				];
			}
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testMergeRecursive($array, $array1, $merge)
	{
		Assert::same($array1, ArrayClass::from($array)->mergeRecursive($merge)->toArray());
	}

}

testCase(new MergeRecursiveTestCase);
