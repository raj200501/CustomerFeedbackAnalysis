<?php

require_once __DIR__ . '/../src/Support/Autoload.php';

use App\App;
use App\Support\Config;

$root = dirname(__DIR__);
$testDatabase = $root . '/storage/test_feedback.sqlite';

putenv('DB_PATH=' . $testDatabase);
putenv('APP_ENV=test');
putenv('SEED_ON_BOOT=false');

if (file_exists($testDatabase)) {
    unlink($testDatabase);
}

$config = Config::fromEnv($root);
$app = new App($config);
$app->migrate($root . '/sql/schema.sql');

return $app;
