<?php

final class Role
{
    private array $permissionMap = [];

    public function __construct(private string $name)
    {}

    public function getName()
    {
        return $this->name;
    }

    public function addPermissions(Resource $resource, array $permissions): self
    {
        $this->permissionMap[$resource->getName()] = $permissions;        
        return $this;
    }

    public function getPermissions(Resource $resource)
    {
        $resourceName = $resource->getName();
        return isset($this->permissionMap[$resourceName]) ? $this->permissionMap[$resourceName] : []; 
    }
}