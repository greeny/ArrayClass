<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class PushTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[1, 2, 3],
			[],
			['a' => 'b', 'c' => 'd'],
		];

		$values = [1, 2, 'b'];

		foreach ($arrays as $array) {
			$original = $array;
			array_push($array, ...$values);
			yield [
				$original,
				$array,
				$values,
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testPush($array, $array1, $values)
	{
		Assert::same($array1, ArrayClass::from($array)->push(...$values)->toArray());
	}

}

testCase(new PushTestCase);
