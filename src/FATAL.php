<?php
namespace Kiss\Errors;

class FATAL extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('error', $callback);
    }
}
