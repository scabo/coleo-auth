<?php

final class Resource
{
    /**
     * Represents a resource with a name and associated permissions.
     *
     * @param string $name The name of the resource.
     * @param array $permissions An array of acceptable permissions for this resource.
     */
    public function __construct(private string $name, private array $permissions)
    {}

    /**
     * Gets the name of the resource.
     *
     * @return string The name of the resource.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets the acceptable permissions for this resource.
     *
     * @return array An array of acceptable permissions.
     */
    public function getAcceptablePermissions(): array
    {
        return $this->permissions;
    }
}
