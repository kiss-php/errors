# KISS-PHP Errors

Kiss errors manager for PHP.

## Install

```bash
composer require kiss-php/errors
```

## Flow

Callbacks do not decide if the program continues.

KISS-PHP Errors follows PHP behavior:

- Warnings, notices, deprecations, and strict errors continue after the callback.
- Errors, parse errors, recoverable errors, and exceptions stop after the callback.
- If there is no callback for an error type, PHP handles it with its default behavior.

Every callback receives an `ErrorInfo` object. You can also receive `$message`, `$file`, `$line`, and `$level`.

## ALL

`ALL::callback` registers the same callback for every error type.

It receives the error type first.

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\ALL;

ALL::callback(function (string $type, $error, $message, $file, $line, $level) {
    echo '[' . $type . '] ' . $message . ' in ' . $file . ':' . $line;
});
```

## WARNING

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\WARNING;

WARNING::callback(function ($error, $message, $file, $line, $level) {
    echo 'Warning: ' . $message . ' in ' . $file . ':' . $line;
});

fopen('missing-file.txt', 'r');
```

Warnings continue after the callback.

## NOTICE

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\NOTICE;

NOTICE::callback(function ($error, $message, $file, $line, $level) {
    echo 'Notice: ' . $message . ' in ' . $file . ':' . $line;
});
```

Notices continue after the callback.

## ERROR

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\ERROR;

ERROR::callback(function ($error, $message, $file, $line, $level) {
    echo 'Error: ' . $message . ' in ' . $file . ':' . $line;
});
```

Errors stop after the callback.

## DEPRECATED

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\DEPRECATED;

DEPRECATED::callback(function ($error, $message, $file, $line, $level) {
    echo 'Deprecated: ' . $message . ' in ' . $file . ':' . $line;
});
```

Deprecations continue after the callback.

## STRICT

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\STRICT;

STRICT::callback(function ($error, $message, $file, $line, $level) {
    echo 'Strict: ' . $message . ' in ' . $file . ':' . $line;
});
```

Strict errors continue after the callback.

## RECOVERABLE

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\RECOVERABLE;

RECOVERABLE::callback(function ($error, $message, $file, $line, $level) {
    echo 'Recoverable error: ' . $message . ' in ' . $file . ':' . $line;
});
```

Recoverable errors stop after the callback.

## PARSE_ERROR

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\PARSE_ERROR;

PARSE_ERROR::callback(function ($error, $message, $file, $line, $level) {
    echo 'Parse error: ' . $message . ' in ' . $file . ':' . $line;
});
```

Parse errors stop after the callback when PHP can report them during shutdown.

## EXCEPTION

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\EXCEPTION;

EXCEPTION::callback(function ($error, $message, $file, $line, $level) {
    echo 'Exception: ' . $message . ' in ' . $file . ':' . $line;
});

$result = 24 / 0;
```

Exceptions stop after the callback.
