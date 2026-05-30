<?php
namespace Kiss\Errors;

class ALL extends TypeCallback {
    public static function callback(callable $callback) : void {
        $wrappedCallback = function ($error, $message, $file, $line, $level) use ($callback) {
            $callback($error->type, $error, $message, $file, $line, $level);
        };

        WARNING::callback($wrappedCallback);
        ERROR::callback($wrappedCallback);
        NOTICE::callback($wrappedCallback);
        DEPRECATED::callback($wrappedCallback);
        STRICT::callback($wrappedCallback);
        RECOVERABLE::callback($wrappedCallback);
        PARSE_ERROR::callback($wrappedCallback);
        EXCEPTION::callback($wrappedCallback);
    }

    public static function calback(callable $callback) : void {
        self::callback($callback);
    }
}
