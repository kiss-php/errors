<?php
namespace Kiss\Errors;

class EXCEPTION extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('exception', $callback);
    }

    public static function calback(callable $callback) : void {
        self::callback($callback);
    }
}
