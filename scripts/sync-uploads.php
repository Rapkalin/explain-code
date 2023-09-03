<?php

require __DIR__ . '/../../website/vendor/autoload.php';

use Dotenv\Dotenv;

// Only allowed for cli
if (PHP_SAPI !== 'cli') {
    die('Not allowed');
}

$start = microtime(true);

// Load .env data
$dotenv = Dotenv::createUnsafeImmutable(__DIR__.'/../../website', '.env');
$dotenv->safeLoad();

// Copy uploads folder on current machine
exec('cp -r ../../../code/shared/uploads ../');

echo 'execution time ' . round(microtime(true) - $start, 2) . ' seconds.';
