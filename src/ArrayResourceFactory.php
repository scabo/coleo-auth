<?php

class ArrayResourceFactory implements ResourceFactoryInterface
{
    private array $resourceMap = [];

    public function __construct(array $resourceMap)
    {
        foreach ($resourceMap as $name => $permissions) {
            if (is_string($name) 
                && is_array($permissions) 
                && count($permissions) === count(array_filter($permissions, 'is_string'))
            ) {
                $this->resourceMap[$name] = $permissions; 
            }
        }
    }

    public function getResource(string $name): ?Resource
    {
        if (isset($this->roleMap[$name])) {
            return new Resource($name, $this->resourceMap[$name]);
        }
    }
}