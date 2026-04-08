<?php

namespace Coleo\Auth\Authorization;

/**
 * Class ResourceFactory is responsible for creating resource instances that
 * will be used throughout an authorization process.
 */
class ResourceFactory implements ResourceFactoryInterface
{
    /**
     * A cache to store and quickly retrieve created resources by their type.
     * This helps improve performance when reusing existing objects instead of always
     * instantiating new ones, which can save on memory usage,
     * reduce garbage collection overheads.
     *
     * @var array
     */
    private array $cache = [];

    public function __construct(private ManagerInterface $manager)
    {
    }

    /**
     * Retrieves a resource by name.
     *
     * If the requested resource has already been created and is stored in this factory's cache,
     * it will be returned directly to avoid creating an unnecessary instance.
     * Otherwise, new instances are fetched using ManagerInterface for creation as needed.
     *
     * @param string $name The unique identifier of the desired resource.
     *
     * @return ResourceInterface An interface representing a specific authorization-related entity or null if not found.
     * @throws \InvalidArgumentException If an invalid name is passed that
     *  doesn't correspond to any existing resources in configuration.
     */
    public function get($name): ?ResourceInterface
    {
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        $resource = $this->manager->getResource($name);
        if (null === $resource) {
            throw new \InvalidArgumentException("Resource '{$name}' not found in configuration");
        }

        // Store the fetched resource into this factory's cache for future use to improve performance.
        $this->cache[$name] = $resource;

        return $resource;
    }
}
