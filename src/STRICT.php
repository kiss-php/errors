<?php
namespace Kiss\Errors;

class STRICT extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('strict', $callback);
    }
}
