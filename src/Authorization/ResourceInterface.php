<?php

namespace Coleo\Auth\Authorization;

interface ResourceInterface
{
    /**
     * Gets the name of the resource.
     *
     * @return string The resource name
     */
    public function getName(): string;

    /**
     * Gets the permissions associated with the resource.
     *
     * @return array List of permission strings
     */
    public function getPermissions(): array;

    /**
     * Checks if the specified roles are allowed to perform the given permissions.
     *
     * @param string|array $roles A single role or an array of roles to check
     * @param string|array $permissions A single permission or an array of permissions to check
     * @return bool True if at least one of the roles has all the required permissions, false otherwise
     */
    public function allowed(string|array $roles, string|array $permissions): bool;

    /**
     * Checks if the specified roles are denied the given permissions.
     *
     * This is the logical negation of allowed().
     *
     * @param string|array $roles A single role or an array of roles to check
     * @param string|array $permissions A single permission or an array of permissions to check
     * @return bool True if none of the roles have all the required permissions, false otherwise
     */
    public function denied(string|array $roles, string|array $permissions): bool;
}