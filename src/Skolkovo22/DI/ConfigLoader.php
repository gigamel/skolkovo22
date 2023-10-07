<?php

namespace Skolkovo22\DI;

class ConfigLoader implements LoaderInterface
{
    /** @var string */
    protected $basePath;
    
    /** @var array */
    protected $config = [];
    
    /**
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * @inheritDoc
     */
    public function import(string $id, string $extension): void
    {
        if (!$this->exists($id, $extension)) {
            return;
        }
        
        $config = require_once($this->resolvePath($id, $extension));
        if (!is_array($config)) {
            return;
        }
        
        $this->config[$id] = array_replace($this->get($id), $config);
    }

    /**
     * @inheritDoc
     */
    public function get(string $id): array
    {
        return is_array($this->config[$id] ?? null) ? $this->config[$id] : [];
    }
    
    /**
     * @param string $id
     * @param string $extension
     *
     * @return bool
     */
    protected function exists(string $id, string $extension): bool
    {
        return file_exists($this->resolvePath($id, $extension));
    }
    
    /**
     * @param string $id
     * @param string $extension
     *
     * @return string
     */
    protected function resolvePath(string $id, string $extension): string
    {
        return $this->basePath . '/' . $id . '.' . $extension;
    }
}
