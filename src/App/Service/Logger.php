<?php

namespace App\Service;

final class Logger
{
    /** @var string */
    private $stream;
    
    /** @var callbable|null */
    private $formatter;
    
    /** @var Hasher */
    private $hasher;
    
    /**
     * @param string $stream
     * @param callable $formatter
     * @param Hasher $hasher
     */
    public function __construct(
        string $stream,
        callable $formatter = null,
        Hasher $hasher
    ) {
        $this->stream = $stream;
        $this->formatter = $formatter;
        $this->hasher = $hasher;
    }
    
    /**
     * @param string $message
     *
     * @return void
     */
    public function warn(string $message): void
    {
        $formatter = $this->formatter;
        
        if ($formatter) {
            $message = $formatter($message, $this->stream);
        } elseif ('default' === $this->stream) {
            $message = 'Logging in default stream, message: ' . $message;
        }
        
        $message = sprintf(
            '[%s] %s',
            date(\DateTimeInterface::RFC3339),
            $this->hasher->md5($message)
        ) . PHP_EOL;
        
        error_log($message, 3, __DIR__ . '/../../../var/log/message.log');
    }
}
