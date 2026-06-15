<?php

namespace Coleo\Auth;

/**
 * Factory for creating Role instances based on an array configuration.
 */
class ArrayRoleFactory implements RoleFactoryInterface
{
    /**
     * Creates role instances based on an array configuration.
     *
     * @param array $roleMap An associative array where keys are role names and values are arrays of resource permissions.
     * @param ResourceFactoryInterface $resourceFactory The factory to use for creating Resource instances.
     */
    private $roleMap = [];
    public function __construct(array $roleMap, private ResourceFactoryInterface $resourceFactory)
    {
        foreach ($roleMap as $name => $resourceMap) {
            if (is_string($name) && is_array($resourceMap)) {
                $this->roleMap[$name] = $resourceMap;
            }
        }
    }

    /**
     * Retrieves a role instance by name.
     *
     * @param string $name The name of the role to retrieve.
     * @return Role|null A Role instance if found, null otherwise.
     */
    public function getRole(string $name): ?Role
    {
        if (isset($this->roleMap[$name]) && is_array($this->roleMap[$name])) {
            $role = new Role($name);
            foreach ($this->roleMap[$name] as $resourceName => $rolePermissions) {
                $resource = $this->resourceFactory->getResource($resourceName);
                if ($resource === null) {
                    throw new \InvalidArgumentException("Resource '$resourceName' not found.");
                }
                $acceptablePermissions = $resource->getAcceptablePermissions();
                if (empty(array_diff($rolePermissions, $acceptablePermissions))) {
                    $role->setPermissions($resource, $rolePermissions);
                } else {
                    throw new \InvalidArgumentException("Role permissions are not a subset of acceptable permissions for resource '$resourceName'.");
                }
            }
            return $role;
        }
        return null;
    }
}
