<?php

namespace Skolkovo22\Http;

class ServerMessage implements ServerMessageInterface
{
    /** @var string */
    protected $content;
    
    /** @var int */
    protected $httpCode;
    
    /** @var array */
    protected $headers;
    
    /**
     * @param string $content
     * @param int $httpCode
     * @param array $headers
     */
    public function __construct(
        string $content = '',
        int $httpCode = self::HTTP_OK,
        array $headers = []
    ) {
        $this->content = $content;
        $this->httpCode = $httpCode;
        $this->headers = $headers; // Todo
    }
    
    /**
     * @inheritDoc
     */
    public function getCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @inheritDoc
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
