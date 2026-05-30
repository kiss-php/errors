<?php
namespace Kiss\Errors;

abstract class TypeCallback {
    protected static function register(string $type, callable $callback) : void {
        Manager::instance()->on($type, $callback);
    }
}
