<?php

namespace App\Service;

final class Logger
{
    /** @var string */
    private $stream;
    
    /** @var callbable|null */
    private $formatter;
    
    /**
     * @param string $stream
     * @param callable $formatter
     */
    public function __construct(string $stream, callable $formatter = null)
    {
        $this->stream = $stream;
        $this->formatter = $formatter;
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
        
        $date = date(\DateTimeInterface::RFC3339);        
        $message = sprintf('[%s] %s', $date, $message) . PHP_EOL;
        
        error_log($message, 3, __DIR__ . '/../../var/log/message.log');
    }
}
