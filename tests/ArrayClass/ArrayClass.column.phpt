<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class ColumnTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[
				['a' => 1, 'b' => 2],
				['a' => 2, 'b' => 1],
				['a' => 2, 'b' => 2],
				['a' => 1, 'b' => 1],
			],
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_column($array, 'a'),
				array_column($array, 'b', 'a'),
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testColumn($array, $array1, $array2)
	{
		Assert::same($array1, ArrayClass::from($array)->column('a')->toArray());
		Assert::same($array2, ArrayClass::from($array)->column('b', 'a')->toArray());
	}

}

testCase(new ColumnTestCase);
