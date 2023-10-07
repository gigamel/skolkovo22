<?php

namespace Skolkovo22\Http\Router;

interface RouteInterface
{
    /**
     * @return string
     */
    public function getName(): string;
    
    /**
     * @return string
     */
    public function getMethod(): string;
    
    /**
     * @return string
     */
    public function getRule(): string;
    
    /**
     * Class name of ActionInterface
     *
     * @return string
     */
    public function getAction(): string;
}
