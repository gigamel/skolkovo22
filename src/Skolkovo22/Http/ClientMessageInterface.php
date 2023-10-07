<?php

namespace Skolkovo22\Http;

interface ClientMessageInterface
{
    public const
        HTTP_METHOD_GET = 'GET',
        HTTP_METHOD_POST = 'POST'
    ;
    
    public const HTTP_METHODS = [
        self::HTTP_METHOD_GET,
        self::HTTP_METHOD_POST,
    ];
    
    /**
     * @return string
     */
    public function getMethod(): string;
    
    /**
     * @return string
     */
    public function getPath(): string;
}
