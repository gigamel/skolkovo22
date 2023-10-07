<?php

namespace Skolkovo22\Http\Router;

use Skolkovo22\Http\ClientMessageInterface;

interface RouterInterface
{    
    /**
     * @param ClientMessageInterface $request
     *
     * @return string
     */
    public function handle(ClientMessageInterface $request): string;
}
