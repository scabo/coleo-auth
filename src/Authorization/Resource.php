<?php

namespace Coleo\Auth\Authorization;

/**
 * Represents an authorization resource with associated permissions.
 */
class Resource implements ResourceInterface
{
   /**
    * Constructs a new Resource instance.
    *
    * @param string $name The name of the resource
    * @param ManagerInterface $manager The manager used to check permissions
    */
    public function __construct(
        private string $name,
        private ManagerInterface $manager
    ) {
    }

   /**
    * Gets the name of the resource.
    *
    * @return string The resource name
    */
    public function getName(): string
    {
        return $this->name;
    }

   /**
    * Checks if the specified roles are allowed to perform the given permissions.
    *
    * @param string|array $roles A single role or an array of roles to check
    * @param string|array $permissions A single permission or an array of permissions to check
    * @return bool True if at least one of the roles has all the required permissions, false otherwise
    * @throws InvalidArgumentException If any of the permissions are invalid for this resource
    */
    public function allowed(string|array $roles, string|array $permissions): bool
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        if (is_string($permissions)) {
            $permissions = [$permissions];
        }

        $permissions = $this->filterPermission($permissions);

        if (!$this->isSubsetOf($this->manager->getResourcePermissions($this->name), $permissions)) {
            throw new \InvalidArgumentException("Invalid permissions", 1);
        }

        foreach ($roles as $role) {
            $rolePermissions = $this->manager->getPermissions($role, $this->name);
            if (!empty($rolePermissions) && $this->isSubsetOf($rolePermissions, $permissions)) {
                return true;
            }
        }

        return false;
    }

   /**
    * Checks if the specified roles are denied the given permissions.
    *
    * This is the logical negation of allowed().
    *
    * @param string|array $roles A single role or an array of roles to check
    * @param string|array $permissions A single permission or an array of permissions to check
    * @return bool True if none of the roles have all the required permissions, false otherwise
    * @throws InvalidArgumentException If any of the permissions are invalid for this resource (from allowed())
    */
    public function denied(string|array $roles, string|array $permissions): bool
    {
        return !$this->allowed($roles, $permissions);
    }

   /**
    * Gets the permissions associated with the resource.
    *
    * @return array List of permission strings
    */
    public function getPermissions(): array
    {
        return $this->manager->getResourcePermissions($this->name);
    }

   /**
    * Normalizes permission strings by trimming, converting to lowercase, and removing duplicates.
    *
    * @param array $permissions Array of permission strings to normalize
    * @return array Normalized array of permission strings
    */
    private function filterPermission(array $permissions): array
    {
        $permissions = array_map('trim', $permissions);
        $permissions = array_map('strtolower', $permissions);
        $permissions = array_unique($permissions);

        return $permissions;
    }

   /**
    * Checks if the given subset is contained within the set.
    *
    * @param array $set The array to check against
    * @param array $subset The array to check if it's a subset
    * @return bool True if all elements of subset exist in set, false otherwise
    */
    private function isSubsetOf(array $set, array $subset): bool
    {
        return empty(array_diff($set, $subset));
    }
}