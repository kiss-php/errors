<?php
namespace Kiss\Errors;

class DEPRECATED extends TypeCallback {
    public static function callback(callable $callback) : void {
        self::register('deprecated', $callback);
    }
}
