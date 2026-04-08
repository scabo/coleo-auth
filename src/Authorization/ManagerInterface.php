<?php

namespace Coleo\Auth\Authorization;

interface ManagerInterface
{
    /**
     * Retrieves a resource by its name.
     *
     * @param string $resource The name of the resource to retrieve
     * @return ResourceInterface|null The resource instance if found, otherwise null
     */
    public function getResource(string $resource): ?ResourceInterface;

    /**
     * Returns the actual permissions granted to a role for a specific resource.
     *
     * @param string $role The role name
     * @param string $resource The resource name
     * @return array An associative array where keys are permission names and values are boolean
     *  flags indicating whether the role has that permission
     */
    public function getPermissions(string $role, string $resource): array;

    /**
     * Returns all possible permissions that can be associated with the given resource.
     *
     * @param string $resource The resource name
     * @return array An associative array where keys are permission names and values are boolean
     *  flags indicating whether the role has that permission
     */
    public function getResourcePermissions(string $resource): array;
}
