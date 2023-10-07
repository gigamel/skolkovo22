<?php

namespace Skolkovo22\Http\Router;

interface RoutesCollectionInterface
{
    /**
     * @return array
     */
    public function getRoutes(): array;
    
    /**
     * @return string
     */
    public function getDefaultAction(): string;
}
