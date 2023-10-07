<?php

namespace Skolkovo22\DI;

interface ConfiguratorInterface
{
    /**
     * @param string $id
     * @param string $className
     *
     * @return mixed
     *
     * @throws \DomainException
     */
    public function newInstance(string $id, string $className);
}
