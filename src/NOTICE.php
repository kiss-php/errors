<?php
namespace Kiss\Errors;

class NOTICE extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('notice', $callback);
    }
}
