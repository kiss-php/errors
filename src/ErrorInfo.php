<?php
namespace Kiss\Errors;

class ErrorInfo {
    /** @var int */
    public $level;

    /** @var string */
    public $message;

    /** @var string */
    public $file;

    /** @var int */
    public $line;

    /** @var string */
    public $type;

    /** @var \Throwable|null */
    public $exception;

    public function __construct(
        int $level,
        string $message,
        string $file,
        int $line,
        string $type,
        ?\Throwable $exception = null
    ) {
        $this->level = $level;
        $this->message = $message;
        $this->file = $file;
        $this->line = $line;
        $this->type = $type;
        $this->exception = $exception;
    }

    public function __toString() : string {
        return $this->type . ': ' . $this->message . ' in ' . $this->file . ':' . $this->line;
    }
}
