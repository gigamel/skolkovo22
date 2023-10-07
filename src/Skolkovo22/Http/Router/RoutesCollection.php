<?php

namespace Skolkovo22\Http\Router;

use Skolkovo22\Http\ClientMessageInterface;

class RoutesCollection implements RoutesCollectionInterface
{
    /** @var string */
    private $defaultAction;
    
    /** @var Route[] */
    private $routes = [];
    
    /**
     * @param string $defaultAction
     */
    public function __construct(string $defaultAction)
    {
        if (!class_exists($defaultAction)) {
            throw new \InvalidArgumentException(sprintf(
                'Argument [defaultAction] must be type string of class name. ' .
                    'Actual [%s].',
                $defaultAction
            ));
        }
        
        $this->defaultAction = $defaultAction;
    }

    /**
     * @param string $name
     * @param string $method
     * @param string $rule
     * @param string $action
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function route(
        string $name,
        string $method,
        string $rule,
        string $action
    ): void {
        $this->routes[] = new Route($name, $method, $rule, $action);
    }
    
    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
    
    /**
     * @param string $name
     * @param string $rule
     * @param string $action
     *
     * @return void
     */
    public function get(string $name, string $rule, string $action): void
    {
        $this->route(
            $name,
            ClientMessageInterface::HTTP_METHOD_GET,
            $rule,
            $action
        );
    }
    
    /**
     * @param string $name
     * @param string $rule
     * @param string $action
     *
     * @return void
     */
    public function post(string $name, string $rule, string $action): void
    {
        $this->route(
            $name,
            ClientMessageInterface::HTTP_METHOD_POST,
            $rule,
            $action
        );
    }
    
    /**
     * @return string
     */
    public function getDefaultAction(): string
    {
        return $this->defaultAction;
    }
}
