<?php

namespace Coleo\Auth;

/**
 * Class to check access based on roles and permissions.
 */
class AccessCheck
{
    /**
     * Checks if the given role has the required permissions for the specified resource.
     *
     * @param Resource $resource The resource to check access for.
     * @param Role $role The role to check permissions for.
     * @param string|array $permissions The permissions to check. Can be a single permission or an array of permissions.
     * @return bool True if the role has the required permissions, false otherwise.
     */
    public function isAllowed(Resource $resource, Role $role, string|array $permissions): bool
    {
        if (\is_string($permissions)) {
            $permissions = [$permissions];
        }

        $permissions = $this->filterPermission($permissions);

        if (!$this->isSubsetOf($resource->getAcceptablePermissions(), $permissions)) {
            throw new \InvalidArgumentException("Passed permissions are incorrect", 1);
        }

        $rolePermissions = $role->getPermissions($resource);
        if (!empty($rolePermissions) && $this->isSubsetOf($rolePermissions, $permissions)) {
            return true;
        }

        return false;
    }

    /**
     * Filters the given permissions by trimming and converting them to lowercase.
     *
     * @param array $permissions The permissions to filter.
     * @return array The filtered permissions.
     */
    private function filterPermission(array $permissions): array
    {
        $permissions = array_map('trim', $permissions);
        $permissions = array_map('strtolower', $permissions);
        $permissions = array_unique($permissions);

        return $permissions;
    }

    /**
     * Checks if the given subset is a subset of the given set.
     *
     * @param array $set The set to check against.
     * @param array $subset The subset to check.
     * @return bool True if the subset is a subset of the set, false otherwise.
     */
    private function isSubsetOf(array $set, array $subset): bool
    {
        return empty(array_diff($subset, $set));
    }
}
