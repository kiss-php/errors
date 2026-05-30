<?php
namespace Kiss\Errors;

class Manager {
    private bool $started = false;
    private array $callbacks = [];
    private string $reservedMemory = '';
    private $previousErrorHandler = null;
    private $previousExceptionHandler = null;

    public static function instance() : Manager {
        if(!isset($GLOBALS['x-open-source-errors'])) $GLOBALS['x-open-source-errors'] = new Manager();
        return $GLOBALS['x-open-source-errors'];
    }

    public function start() : void {
        if($this->started) return;

        $this->started = true;
        $this->reservedMemory = str_repeat(' ', 1024 * 64);
        error_reporting(E_ALL);

        $this->previousErrorHandler = set_error_handler([$this, 'handlePhpError']);
        $this->previousExceptionHandler = set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutdown']);
    }

    public function stop() : void {
        if(!$this->started) return;

        restore_error_handler();
        restore_exception_handler();
        $this->reservedMemory = '';
        $this->previousErrorHandler = null;
        $this->previousExceptionHandler = null;
        $this->started = false;
    }

    public function on(string $type, callable $callback) : void {
        $this->callbacks[$type] = $callback;
        $this->start();
    }

    public function handlePhpError(int $level, string $message, string $file = '', int $line = 0) : bool {
        if(!(error_reporting() & $level)) return true;

        $error = new ErrorInfo($level, $message, $file, $line, $this->typeFromLevel($level));
        if(!$this->hasCallback($error->type)) return $this->defaultPhpError($level, $message, $file, $line);

        return $this->dispatch($error);
    }

    public function handleException(\Throwable $exception) : void {
        $error = new ErrorInfo(
            E_ERROR,
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            'exception',
            $exception
        );

        if($this->hasCallback($error->type)) {
            $this->dispatch($error);
            return;
        }

        if(is_callable($this->previousExceptionHandler)) {
            call_user_func($this->previousExceptionHandler, $exception);
            return;
        }

        echo 'Fatal error: Uncaught ' . get_class($exception) . ': ' . $exception->getMessage()
            . ' in ' . $exception->getFile() . ':' . $exception->getLine() . PHP_EOL;
        exit(255);
    }

    public function handleShutdown() : void {
        if(!$this->started) return;

        $this->reservedMemory = '';

        $lastError = error_get_last();
        if($lastError === null) return;

        $fatalLevels = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR];
        if(!in_array($lastError['type'], $fatalLevels, true)) return;

        $error = new ErrorInfo(
            $lastError['type'],
            $lastError['message'],
            $lastError['file'],
            $lastError['line'],
            $this->typeFromLevel($lastError['type'])
        );

        if(!$this->hasCallback($error->type)) return;

        $this->dispatch($error);
    }

    private function hasCallback(string $type) : bool {
        return is_callable($this->callbacks[$type] ?? null);
    }

    private function defaultPhpError(int $level, string $message, string $file, int $line) : bool {
        if(is_callable($this->previousErrorHandler)) {
            return call_user_func($this->previousErrorHandler, $level, $message, $file, $line) !== false;
        }

        return false;
    }

    private function dispatch(ErrorInfo $error) : bool {
        $callback = $this->callbacks[$error->type] ?? null;

        if(!is_callable($callback)) return $this->continuesAfterCallback($error->type);

        $callback($error, $error->message, $error->file, $error->line, $error->level);
        if($this->continuesAfterCallback($error->type)) return true;

        exit(1);
    }

    private function continuesAfterCallback(string $type) : bool {
        return in_array($type, ['warning', 'notice', 'deprecated', 'strict'], true);
    }

    private function typeFromLevel(int $level) : string {
        switch($level) {
            case E_WARNING:
            case E_USER_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
                return 'warning';

            case E_NOTICE:
            case E_USER_NOTICE:
                return 'notice';

            case E_DEPRECATED:
            case E_USER_DEPRECATED:
                return 'deprecated';

            case E_STRICT:
                return 'strict';

            case E_RECOVERABLE_ERROR:
                return 'recoverable';

            case E_PARSE:
                return 'parse';

            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                return 'error';

            default:
                return 'error';
        }
    }
}
