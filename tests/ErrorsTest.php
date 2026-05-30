<?php
require __DIR__ . '/../src/ErrorInfo.php';
require __DIR__ . '/../src/Manager.php';
require __DIR__ . '/../src/TypeCallback.php';
require __DIR__ . '/../src/WARNING.php';
require __DIR__ . '/../src/ERROR.php';
require __DIR__ . '/../src/NOTICE.php';
require __DIR__ . '/../src/DEPRECATED.php';
require __DIR__ . '/../src/STRICT.php';
require __DIR__ . '/../src/RECOVERABLE.php';
require __DIR__ . '/../src/PARSE_ERROR.php';
require __DIR__ . '/../src/EXCEPTION.php';
require __DIR__ . '/../src/ALL.php';

use Kiss\Errors\ALL;
use Kiss\Errors\NOTICE;
use Kiss\Errors\WARNING;

$received = [];

WARNING::callback(function ($error, $message, $file, $line, $level) use (&$received) {
    $received[] = [$error->type, $message, $file, $line, $level];
});

trigger_error('Test warning', E_USER_WARNING);

if(count($received) !== 1) {
    echo "Expected one warning\n";
    exit(1);
}

if($received[0][0] !== 'warning' || $received[0][1] !== 'Test warning') {
    echo "Unexpected warning data\n";
    exit(1);
}

NOTICE::callback(function () use (&$received) {
    $received[] = ['notice'];
});

trigger_error('Test notice', E_USER_NOTICE);

if(count($received) !== 2 || $received[1][0] !== 'notice') {
    echo "Expected one notice\n";
    exit(1);
}

ALL::callback(function (string $type, $error) use (&$received) {
    $received[] = ['all', $type];
});

trigger_error('All warning', E_USER_WARNING);
trigger_error('All notice', E_USER_NOTICE);

if(count($received) !== 4 || $received[2][1] !== 'warning' || $received[3][1] !== 'notice') {
    echo "Expected ALL to register every type\n";
    exit(1);
}

echo "OK\n";
