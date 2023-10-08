<?php

namespace Skolkovo22\DI;

class ServiceConfigurator implements ConfiguratorInterface
{
    /** @var LoaderInterface */
    protected $loader;

    /**
     * @param LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @inheritDoc
     */
    public function newInstance(
        string $id,
        string $className,
        ContainerInterface $container
    ) {
        $rc = new \ReflectionClass($className);

        if ($rc->isAbstract()) {
            throw new \RuntimeException(
                sprintf('Service [%s] should not be Abstract.', $className)
            );
        }

        $constructor = $rc->getConstructor();
        if (null === $constructor) {
            return $rc->newInstance();
        }

        if ($constructor->isAbstract() || !$constructor->isPublic()) {
            throw new \RuntimeException(
                sprintf(
                    'Method %s::%s(...) should be public and no abstract.',
                    $className,
                    '__construct'
                )
            );
        }
        
        $serviceConfig = $this->loader->get($id);

        $parameters = [];
        foreach ($constructor->getParameters() as $parameter) {
            $parameters[$parameter->getName()]
                = $this->resolveParameter(
                    $container,
                    $parameter,
                    $serviceConfig,
                    $className
                );
        }
        
        return $rc->newInstanceArgs($parameters);
    }
    
    /**
     * @param ContainerInterface $container
     * @param \ReflectionParameter $parameter
     * @param array $serviceConfig
     * @param string $className
     *
     * @return mixed
     *
     * @throws \DomainException
     */
    protected function resolveParameter(
        ContainerInterface $container,
        \ReflectionParameter $parameter,
        array $serviceConfig,
        string $className
    ) {
        switch (true) {
            case array_key_exists($parameter->getName(), $serviceConfig):
                return $this->resolveConfig(
                    $container,
                    $parameter,
                    $serviceConfig
                );

            case $parameter->isDefaultValueAvailable():
                return $parameter->getDefaultValue();

            case $parameter->allowsNull():
                return null;

            default:
                throw new \DomainException(
                    sprintf(
                        'Undefined parameter [%s] for service [%s].',
                        $parameter->getName(),
                        $className
                    )
                );
        }
    }
    
    /**
     * @param ContainerInterface $container
     * @param \ReflectionParameter $parameter
     * @param array $serviceConfig
     *
     * @return mixed
     */
    protected function resolveConfig(
        ContainerInterface $container,
        \ReflectionParameter $parameter,
        array $serviceConfig
    ) {
        $config = $serviceConfig[$parameter->getName()];
        if (is_string($config) && '@' === substr($config, 0, 1)) {
            $id = substr($config, 1);
            if (!$container->has($id)) {
                $this->loader->import($id, 'php');
                return $this->newInstance(
                    $id,
                    $parameter->getType()->getName(),
                    $container
                );
            }
            
            return $container->get($id);
        }
        
        return $config;
    }
}
