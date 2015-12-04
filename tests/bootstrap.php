<?php
/**
 * @author Tomáš Blatný
 */

use Tester\Environment;
use Tester\TestCase;


require_once __DIR__ . '/../vendor/autoload.php';

Environment::setup();

function dump($var) {
	print_r($var);
	return $var;
}

function testCase(TestCase $testCase) {
	$testCase->run();
}
