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
    echo 'Warning: ' . $message;
});

fopen('missing-file.txt', 'r');
```

Warnings continue after the callback.

## NOTICE

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\NOTICE;

NOTICE::callback(function ($error) {
    echo $error;
});
```

Notices continue after the callback.

## ERROR

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\ERROR;

ERROR::callback(function ($error) {
    echo 'Error: ' . $error->message;
});
```

Errors stop after the callback.

## DEPRECATED

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\DEPRECATED;

DEPRECATED::callback(function ($error) {
    echo 'Deprecated: ' . $error->message;
});
```

Deprecations continue after the callback.

## STRICT

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\STRICT;

STRICT::callback(function ($error) {
    echo 'Strict: ' . $error->message;
});
```

Strict errors continue after the callback.

## RECOVERABLE

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\RECOVERABLE;

RECOVERABLE::callback(function ($error) {
    echo 'Recoverable error: ' . $error->message;
});
```

Recoverable errors stop after the callback.

## PARSE_ERROR

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\PARSE_ERROR;

PARSE_ERROR::callback(function ($error) {
    echo 'Parse error: ' . $error->message;
});
```

Parse errors stop after the callback when PHP can report them during shutdown.

## EXCEPTION

```php
<?php
require 'vendor/autoload.php';

use Kiss\Errors\EXCEPTION;

EXCEPTION::callback(function ($error) {
    echo 'Exception: ' . $error->message;
});

$result = 24 / 0;
```

Exceptions stop after the callback.
