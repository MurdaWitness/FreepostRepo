<?php

define('APP_DIR', dirname(__DIR__));

require_once APP_DIR . '/vendor/autoload.php';

use App\Kernel\Application;

$app = new Application();

$app->run();