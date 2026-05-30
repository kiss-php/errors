<?php
namespace Kiss\Errors;

class PARSE_ERROR extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('parse', $callback);
    }
}
