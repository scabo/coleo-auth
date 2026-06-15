<?php

namespace Coleo\Auth;

/**
 * Represents a role with a name and associated permissions for resources.
 */
final class Role
{
    /**
     * Creates a new Role instance.
     *
     * @param string $name The name of the role.
     */
    private array $permissionMap = [];

    public function __construct(private string $name)
    {}

    /**
     * Gets the name of the role.
     *
     * @return string The name of the role.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set permissions for a specific resource to this role.
     *
     * @param Resource $resource The resource to add permissions for.
     * @param array $permissions An array of permissions to add for the resource.
     * @return self Returns the current Role instance.
     */
    public function setPermissions(Resource $resource, array $permissions): self
    {
        $this->permissionMap[$resource->getName()] = $permissions;        
        return $this;
    }

    /**
     * Gets the permissions associated with a specific resource for this role.
     *
     * @param Resource $resource The resource to get permissions for.
     * @return array An array of permissions for the resource, or an empty array if no permissions are set.
     */
    public function getPermissions(Resource $resource)
    {
        $resourceName = $resource->getName();
        return isset($this->permissionMap[$resourceName]) ? $this->permissionMap[$resourceName] : []; 
    }
}
