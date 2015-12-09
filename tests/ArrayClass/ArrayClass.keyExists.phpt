<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class KeyExistsTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[
				1 => 2,
				2 => 42,
			],
			[
				42 => 'The Hitchhiker\'s Guide to the Galaxy',
			],
		];

		$keys = [1, 42];

		foreach ($arrays as $array) {
			foreach ($keys as $key) {
				yield [
					$array,
					array_key_exists($key, $array),
					$key,
				];
			}
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testKeyExists($array, $bool, $key)
	{
		Assert::same($bool, ArrayClass::from($array)->keyExists($key));
	}

}

testCase(new KeyExistsTestCase);
