<?php
namespace Kiss\Errors;

class FATAL extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('error', $callback);
    }

    public static function calback(callable $callback) : void {
        self::callback($callback);
    }
}
