<?php

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
        if (isset($this->roleMap[$name]) && is_string($this->roleMap[$name])) {
            $role = new Role($name);
            foreach ($this->roleMap[$name] as $resourceName => $rolePermissions) {
                $resource = $this->resourceFactory->getResource($resourceName);
                if (empty(array_diff($resource->getAcceptablePermissions(), $rolePermissions))) {
                    $role->addPermissions($resource, $rolePermissions);
                }
            }
            return $role;
        }
    }
}
