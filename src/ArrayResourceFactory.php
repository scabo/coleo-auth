<?php

namespace Coleo\Auth;

/**
 * Factory for creating Resource instances based on an array configuration.
 */
class ArrayResourceFactory implements ResourceFactoryInterface
{
    /**
     * Creates resource instances based on an array configuration.
     *
     * @param array $resourceMap An associative array where keys are resource names and values are arrays of permissions.
     */
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

    /**
     * Retrieves a resource instance by name.
     *
     * @param string $name The name of the resource to retrieve.
     * @return Resource|null A Resource instance if found, null otherwise.
     */
    public function getResource(string $name): ?Resource
    {
        if (isset($this->resourceMap[$name])) {
            return new Resource($name, $this->resourceMap[$name]);
        }
    }
}
