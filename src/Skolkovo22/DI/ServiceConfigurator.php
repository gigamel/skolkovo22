<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace Skolkovo22\DI;

/**
 * Description of Configurator
 *
 * @author gigamel
 */
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
    public function newInstance(string $id, string $className)
    {
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
        
        $this->loader->import($id, 'php');
        $serviceConfig = $this->loader->get($id);

        $parameters = [];
        foreach ($constructor->getParameters() as $parameter) {
            $parameters[$parameter->getName()]
                = $this->resolveParameter(
                    $parameter,
                    $serviceConfig,
                    $className
                );
        }
        
        return $rc->newInstanceArgs($parameters);
    }
    
    /**
     * @param \ReflectionParameter $parameter
     * @param array $serviceConfig
     * @param string $className
     *
     * @return mixed
     *
     * @throws \DomainException
     */
    protected function resolveParameter(
        \ReflectionParameter $parameter,
        array $serviceConfig,
        string $className
    ) {
        switch (true) {
            case array_key_exists($parameter->getName(), $serviceConfig):
                return $serviceConfig[$parameter->getName()];

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
}
