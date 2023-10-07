<?php

namespace Skolkovo22\Http\Router;

use Skolkovo22\Http\ClientMessageInterface;

class Router implements RouterInterface
{
    /** @var RoutesCollection */
    private $collection;
    
    /**
     * @param RoutesCollection $collection
     */
    public function __construct(RoutesCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @inheritDoc
     */
    public function handle(ClientMessageInterface $request): string
    {
        foreach ($this->collection->getRoutes() as $route) {
            if ($route->getMethod() !== $request->getMethod()) {
                continue;
            }
            
            if ($route->getRule() !== $request->getPath()) {
                continue;
            }
            
            return $route->getAction();
        }
        
        return $this->collection->getDefaultAction();
    }
}
