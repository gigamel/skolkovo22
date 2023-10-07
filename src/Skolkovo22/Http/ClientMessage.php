<?php

namespace Skolkovo22\Http;

class ClientMessage implements ClientMessageInterface
{
    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
}
