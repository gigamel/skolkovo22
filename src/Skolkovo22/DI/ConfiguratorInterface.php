<?php

namespace Skolkovo22\DI;

interface ConfiguratorInterface
{
    /**
     * @param string $id
     * @param string $className
     * @param ContainerInterface $container
     *
     * @return mixed
     *
     * @throws \DomainException
     */
    public function newInstance(
        string $id,
        string $className,
        ContainerInterface $container
    );
}
