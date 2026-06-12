<?php

final class Resource
{
    public function __construct(private string $name, private array $permissions)
    {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getAcceptablePermissions(): array
    {
        return $this->permissions;
    }
}