<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class PadTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[1, 2, 3, 4, 5, 6],
			[],
			[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
		];

		$size = 10;
		$value = 'a';

		foreach ($arrays as $array) {
			yield [
				$array,
				array_pad($array, $size, $value),
				$size,
				$value,
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testPad($array, $array1, $size, $value)
	{
		Assert::same($array1, ArrayClass::from($array)->pad($size, $value)->toArray());
	}

}

testCase(new PadTestCase);
