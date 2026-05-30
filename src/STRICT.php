<?php
namespace Kiss\Errors;

class STRICT extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('strict', $callback);
    }

    public static function calback(callable $callback) : void {
        self::callback($callback);
    }
}
