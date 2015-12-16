<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class MergeTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[5, 3, 4],
			['b' => 5, 'a' => 3, 'c' => 4],
		];

		$mergeArrays = [
			[
				[1, 2, 3],
				['a' => 1, 'b' => 2, 'c' => 3],
			]
		];

		foreach ($arrays as $array) {
			foreach ($mergeArrays as $merge) {
				yield [
					$array,
					array_merge($array, $merge),
					$merge,
				];
			}
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testMerge($array, $array1, $merge)
	{
		Assert::same($array1, ArrayClass::from($array)->merge($merge)->toArray());
	}

}

testCase(new MergeTestCase);
