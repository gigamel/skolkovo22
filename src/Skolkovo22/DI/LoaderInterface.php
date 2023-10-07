<?php

namespace Skolkovo22\DI;

interface LoaderInterface
{
    /**
     * @param string $id
     *
     * @return array
     *
     * @throws \DomainException
     */
    public function get(string $id): array;
    
    /**
     * @param string $id
     * @param string $extension
     *
     * @return void
     */
    public function import(string $id, string $extension): void;
}
