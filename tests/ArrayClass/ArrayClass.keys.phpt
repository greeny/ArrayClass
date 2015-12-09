<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class KeysTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[
				12 => 1,
				'12a' => 1,
				'a' => 1,
				NULL => 1,
				'' => 1,
			],
		];

		$searches = [
			NULL,
			12,
			'a',
		];

		foreach ($arrays as $array) {
			foreach ($searches as $search) {
				yield [
					$array,
					array_keys($array, $search, TRUE),
					$search,
				];
			}
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testKeys($array, $array1, $search)
	{
		Assert::same($array1, ArrayClass::from($array)->keys($search)->toArray());
	}

}

testCase(new KeysTestCase);
