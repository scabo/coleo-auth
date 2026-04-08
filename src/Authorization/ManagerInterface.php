<?php

namespace Coleo\Auth\Authorization;

interface ManagerInterface
{
    /**
     * Retrieves a resource by its name.
     *
     * @param string $resource The name of the resource to retrieve
     * @return ResourceInterface The resource instance
     */
    public function getResource(string $resource): ResourceInterface|null;

    /**
     * Returns the actual permissions granted to a role for a specific resource.
     *
     * @param string $role The role name
     * @param string $resource The resource name
     * @return array The list of permissions for the role-resource pair
     */
    public function getPermissions(string $role, string $resource): array;

    /**
     * Returns all possible permissions that can be associated with the given resource.
     *
     * @param string $resource The resource name
     * @return array The list of all valid permissions for the resource
     */
    public function getResourcePermissions(string $resource): array;
}