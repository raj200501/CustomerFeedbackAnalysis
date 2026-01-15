<?php

$app = require __DIR__ . '/bootstrap.php';
$GLOBALS['app'] = $app;
require_once __DIR__ . '/Framework/TestCase.php';
require_once __DIR__ . '/Framework/TestRunner.php';

use Tests\Framework\TestRunner;

$testFiles = glob(__DIR__ . '/Unit/*.php');
$testFiles = array_merge($testFiles, glob(__DIR__ . '/Integration/*.php'));

foreach ($testFiles as $file) {
    require_once $file;
}

$testClasses = array_filter(get_declared_classes(), fn($class) => str_starts_with($class, 'Tests\\'));

$runner = new TestRunner();
exit($runner->run($testClasses));
