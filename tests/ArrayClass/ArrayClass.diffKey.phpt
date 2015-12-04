<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class DiffKeyTestCase extends TestCase
{

	public function dataProvider()
	{
		$master = [2, 3, 4];
		$arrays = [
			[1, 2, 3, 4, 5],
			[2, 3, 4],
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_diff_key($array, $master),
				$master,
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testDiffKey($array, $array1, $master)
	{
		Assert::same($array1, ArrayClass::from($array)->diffKey($master)->toArray());
		Assert::same($array1, ArrayClass::from($array)->diffKey(ArrayClass::from($master))->toArray());
	}

}

testCase(new DiffKeyTestCase);
