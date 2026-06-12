<?php

interface RoleFactoryInterface
{
    public function getRole(string $name): ?Role;
}