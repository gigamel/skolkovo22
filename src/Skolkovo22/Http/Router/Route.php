<?php

namespace Skolkovo22\Http\Router;

class Route implements RouteInterface
{
    /** @var string */
    private $name;
    
    /** @var string */
    private $method;
    
    /** @var string */
    private $rule;
    
    /** @var string */
    private $action;
    
    /**
     * @param string $name
     * @param string $method
     * @param string $rule
     * @param string $action
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        string $name,
        string $method,
        string $rule,
        string $action
    ) {
        if (!class_exists($action)) {
            throw new \InvalidArgumentException(sprintf(
                'Argument [action] must be type string of class name. ' .
                    'Actual [%s].',
                $action
            ));
        }
        
        $this->name = $name;
        $this->method = $method;
        $this->rule = $rule;
        $this->action = $action;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getRule(): string
    {
        return $this->rule;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }
}
