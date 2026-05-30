# KISS-PHP Errors

Small PHP error handler for KISS-PHP.

## Install

```bash
composer require kiss-php/errors
```

## Use

```php
require 'vendor/autoload.php';

use Kiss\Errors\WARNING;
use Kiss\Errors\NOTICE;

WARNING::callback(function ($error, $message, $file, $line, $level) {
    echo $error;
});

NOTICE::callback(function ($error) {
    echo $error;
});
```

Available callbacks:

```php
ALL::callback(function (string $type, $error) {}); // Same callback for every error type.
WARNING::callback(function ($error) {});
ERROR::callback(function ($error) {});
NOTICE::callback(function ($error) {});
DEPRECATED::callback(function ($error) {});
STRICT::callback(function ($error) {});
RECOVERABLE::callback(function ($error) {});
PARSE_ERROR::callback(function ($error) {});
FATAL::callback(function ($error) {});
EXCEPTION::callback(function ($error) {});
```

The callback receives an `ErrorInfo` object first. You can also receive `$message`, `$file`, `$line`, and `$level` as extra arguments.

`ALL::callback` receives the error type first, then the `ErrorInfo` object and the other arguments.

Callbacks do not control the program flow.

Warnings, notices, deprecations, and strict errors continue after the callback, just like PHP.

Errors, parse errors, recoverable errors, and exceptions stop the program after the callback.

If there is no callback for an error type, PHP handles it with its default behavior.
