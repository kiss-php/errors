<?php
namespace Kiss\Errors;

class RECOVERABLE extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('recoverable', $callback);
    }
}
