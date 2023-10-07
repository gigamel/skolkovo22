<?php

namespace Skolkovo22\DI;

interface ContainerInterface
{
    /**
     * @param string $id
     *
     * @return mixed
     *
     * @throws \DomainException
     */
    public function get(string $id);
    
    /**
     * @param string $id
     * @param string $className
     *
     * @return void
     */
    public function put(string $id, string $className): void;
    
    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool;
}
