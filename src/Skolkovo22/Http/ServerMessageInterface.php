<?php

namespace Skolkovo22\Http;

interface ServerMessageInterface
{
    public const
        HTTP_OK = 200,
        HTTP_NOT_FOUND = 404
    ;
    
    /**
     * @return array
     */
    public function getHeaders(): array;
    
    /**
     * @return int
     */
    public function getCode(): int;
    
    /**
     * @return string
     */
    public function getContent(): string;
}
