<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class MapTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[
				1, 12, 123, 1234, 12345, 123456, 1234567, 12345678, 123456789
			],
		];

		$maps = [
			function ($item) {
				return ++$item;
			},
			function ($item) {
				return strlen((string) $item);
			},
		];

		foreach ($arrays as $array) {
			foreach ($maps as $map) {
				yield [
					$array,
					array_map($map, $array),
					$map,
				];
			}
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testMap($array, $array1, $map)
	{
		Assert::same($array1, ArrayClass::from($array)->map($map)->toArray());
	}

}

testCase(new MapTestCase);
