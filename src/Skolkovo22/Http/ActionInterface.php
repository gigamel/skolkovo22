<?php

namespace Skolkovo22\Http;

interface ActionInterface
{
    /**
     * @param ClientMessageInterface $request
     *
     * @return ServerMessageInterface
     */
    public function __invoke(
        ClientMessageInterface $request
    ): ServerMessageInterface;
}
