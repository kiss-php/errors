<?php
namespace Kiss\Errors;

class NOTICE extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('notice', $callback);
    }

    public static function calback(callable $callback) : void {
        self::callback($callback);
    }
}
