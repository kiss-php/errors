<?php
namespace Kiss\Errors;

class ERROR extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('error', $callback);
    }
}
