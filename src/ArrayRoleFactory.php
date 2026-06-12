<?php

class ArrayRoleFactory implements RoleFactoryInterface
{
    private $roleMap = [];
    public function __construct(array $roleMap, private ResourceFactoryInterface $resourceFactory)
    {
        foreach ($roleMap as $name => $resourceMap) {
            
        }
    }

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