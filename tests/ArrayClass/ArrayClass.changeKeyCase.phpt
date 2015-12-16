<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class ChangeKeyCaseTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[
				'UPPER' => 1,
				'lower' => 1,
				'mIxEd' => 1,
			],
			[1, 2, 3]
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_change_key_case($array, CASE_LOWER),
				array_change_key_case($array, CASE_UPPER),
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testChangeKeyCase($array, $lcArray, $ucArray)
	{
		Assert::same($lcArray, ArrayClass::from($array)->changeKeyCase(CASE_LOWER)->toArray());
		Assert::same($ucArray, ArrayClass::from($array)->changeKeyCase(CASE_UPPER)->toArray());
	}

}

testCase(new ChangeKeyCaseTestCase);
