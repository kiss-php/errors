<?php
namespace Kiss\Errors;

class WARNING extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('warning', $callback);
    }

    public static function calback(callable $callback) : void {
        self::callback($callback);
    }
}
