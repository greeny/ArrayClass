<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class CountValuesTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[1, 1, 1, 2, 2, 3, 3, 3, 3, 3, 3, 4, 5],
			[],
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_count_values($array),
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testCountValues($array, $array1)
	{
		Assert::same($array1, ArrayClass::from($array)->countValues()->toArray());
	}

}

testCase(new CountValuesTestCase);
