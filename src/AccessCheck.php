<?php

class AccessCheck
{
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

    private function filterPermission(array $permissions): array
    {
        $permissions = array_map('trim', $permissions);
        $permissions = array_map('strtolower', $permissions);
        $permissions = array_unique($permissions);

        return $permissions;
    }

    private function isSubsetOf(array $set, array $subset): bool
    {
        return empty(array_diff($set, $subset));
    }
}