<?php

namespace Skolkovo22\DI;

class ServicesContainer implements ContainerInterface
{
    /** @var ConfiguratorInterface */
    protected $configurator;
    
    /** @var array */
    protected $container = [];

    /**
     * @param ConfiguratorInterface $configurator
     */
    public function __construct(ConfiguratorInterface $configurator)
    {
        $this->configurator = $configurator;
    }

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            return $this->container[$id];
        }
        
        throw new \DomainException(
            sprintf('Service by [%s] not found.', $id)
        );
    }

    /**
     * @inheritDoc
     */
    public function put(string $id, string $className): void
    {
        if ($this->has($id)) {
            return;
        }
        
        $this->container[$id] = $this->configurator->newInstance(
            $id,
            $className
        );
    }
    
    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->container);
    }
}
