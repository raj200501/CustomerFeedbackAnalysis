<?php

require_once __DIR__ . '/../src/Support/Autoload.php';

use App\App;
use App\Support\Config;

$root = dirname(__DIR__);

$databasePath = getenv('DB_PATH') ?: $root . '/storage/feedback.sqlite';
$seed = strtolower(getenv('SEED_ON_BOOT') ?: 'true') === 'true';

$config = Config::fromEnv($root);
$app = new App($config);
$app->migrate($root . '/sql/schema.sql', $seed ? $root . '/sql/sample_data.sql' : null);

echo "Database ready at {$databasePath}\n";
