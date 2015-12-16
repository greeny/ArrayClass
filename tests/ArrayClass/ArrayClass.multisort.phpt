<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class MultisortTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[
				'a' => 'b',
				'1' => 2,
				'10' => 15,
				9 => 7,
				12 => 8,
			],
			[
				'b' => 'b',
				'2' => 2,
				'9' => 15,
				11 => 7,
				1 => 8,
			]
		];

		$flags = [
			SORT_ASC,
			SORT_DESC,
			SORT_REGULAR,
			SORT_NATURAL,
		];

		foreach ($arrays as $array) {
			foreach ($flags as $flag) {
				$original = $array;
				array_multisort($array, $flag);
				yield [
					$original,
					$array,
					$flag,
				];
			}
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testMultisort($array, $array1, $flag)
	{
		Assert::same($array1, ArrayClass::from($array)->multisort($flag)->toArray());
	}

}

testCase(new MultisortTestCase);
