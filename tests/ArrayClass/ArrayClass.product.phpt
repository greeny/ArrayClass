<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class ProductTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[1, 2, 3, 4, 5, 6, 7, 8, 9],
			[1, 1, 1, 1, 1, 1, 1, 1, 2],
			['a', 'b', 'c'],
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_product($array),
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testProduct($array, $value)
	{
		Assert::same($value, ArrayClass::from($array)->product());
	}

}

testCase(new ProductTestCase);
