<?php

require_once __DIR__ . '/Support/Autoload.php';

use App\App;
use App\Support\Config;
use App\Support\Dotenv;

$root = dirname(__DIR__);
$dotenv = new Dotenv($root . '/.env');
$dotenv->load();

$config = Config::fromEnv($root);
$app = new App($config);
$app->migrate($root . '/sql/schema.sql', $root . '/sql/sample_data.sql');

return $app;
