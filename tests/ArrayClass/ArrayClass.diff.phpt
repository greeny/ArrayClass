<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class DiffTestCase extends TestCase
{

	public function dataProvider()
	{
		$master = [2, 4, 6];

		$arrays = [
			[2, 4, 6, 8, 10],
			[4, 6, 8],
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_diff($array, $master),
				$master,
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testDiff($array, $array1, $master)
	{
		Assert::same($array1, ArrayClass::from($array)->diff($master)->toArray());
		Assert::same($array1, ArrayClass::from($array)->diff(ArrayClass::from($master))->toArray());
	}

}

testCase(new DiffTestCase);
