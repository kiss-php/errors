<?php
require __DIR__ . '/src/ErrorInfo.php';
require __DIR__ . '/src/Manager.php';
require __DIR__ . '/src/TypeCallback.php';
require __DIR__ . '/src/WARNING.php';
require __DIR__ . '/src/ERROR.php';
require __DIR__ . '/src/NOTICE.php';
require __DIR__ . '/src/DEPRECATED.php';
require __DIR__ . '/src/STRICT.php';
require __DIR__ . '/src/RECOVERABLE.php';
require __DIR__ . '/src/PARSE_ERROR.php';
require __DIR__ . '/src/EXCEPTION.php';
require __DIR__ . '/src/ALL.php';

use Kiss\Errors\ALL;
use Kiss\Errors\DEPRECATED;
use Kiss\Errors\ERROR;
use Kiss\Errors\EXCEPTION;
use Kiss\Errors\NOTICE;
use Kiss\Errors\WARNING;

// ALL assigns the same callback to every error type.
ALL::callback(function (string $type, $error) {
    echo "[ALL:" . $type . "] " . $error . PHP_EOL;
});
/*
// This callback catches PHP warnings: E_WARNING and E_USER_WARNING.
// It replaces the callback assigned by ALL only for warnings.
WARNING::callback(function ($error, $message, $file, $line, $level) {
    echo "[WARNING] " . $message . PHP_EOL;
    echo "File: " . $file . ':' . $line . PHP_EOL;
});

// This callback catches PHP notices: E_NOTICE and E_USER_NOTICE.
NOTICE::callback(function ($error) {
    echo "[NOTICE] " . $error . PHP_EOL;
});

// This callback catches fatal/user errors: E_ERROR and E_USER_ERROR.
ERROR::callback(function ($error) {
    echo "[ERROR] " . $error->message . PHP_EOL;

    // Errors stop the program after the callback.
});

// This callback catches deprecation notices: E_DEPRECATED and E_USER_DEPRECATED.
DEPRECATED::callback(function ($error) {
    echo "[DEPRECATED] " . $error->message . PHP_EOL;
});

// This callback catches uncaught exceptions.
EXCEPTION::callback(function ($error) {
    echo "[EXCEPTION] " . $error->message . PHP_EOL;
});
*/
// This callback catches any error type without a more specific callback.
echo "Starting KISS-PHP Errors demo..." . PHP_EOL . PHP_EOL;

// Real warning example: the file does not exist.
fopen(__DIR__ . '/missing-file.txt', 'r');
echo PHP_EOL;

// Real warning/notice-style example: nested array keys do not exist.
$var = [];
$value = $var['test']['test'];
echo PHP_EOL;

// Another real warning example: include cannot find the file.
include __DIR__ . '/missing-include.php';
echo PHP_EOL;

echo "Starting 200ms request timeout demo..." . PHP_EOL;

// Request timeout example: this request cannot last more than 200ms.
$requestStartedAt = microtime(true);
$maxRequestTime = 0.200;
$calculation = 1;

while (true) {
    // Infinite calculation.
    $calculation *= 2;
    if($calculation > PHP_INT_MAX / 2) $calculation = 1;

    // Portable 200ms watchdog. PHP's built-in max_execution_time uses seconds,
    // so millisecond request limits need an explicit check like this.
    if(microtime(true) - $requestStartedAt >= $maxRequestTime) {
        throw new RuntimeException('Request exceeded 200ms');
    }
}
