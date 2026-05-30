<?php
require __DIR__ . '/../src/ErrorInfo.php';
require __DIR__ . '/../src/Manager.php';
require __DIR__ . '/../src/TypeCallback.php';
require __DIR__ . '/../src/ERROR.php';

use Kiss\Errors\ERROR;

ERROR::callback(function ($error) {
    echo "handled error\n";
});

trigger_error('Stop here', E_USER_ERROR);

echo "should not continue\n";
