<?php
namespace Kiss\Errors;

class ErrorInfo {
    public int $level;
    public string $message;
    public string $file;
    public int $line;
    public string $type;
    public ?\Throwable $exception;

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
