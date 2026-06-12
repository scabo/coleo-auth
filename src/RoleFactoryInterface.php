<?php

namespace Coleo\Auth;

/**
 * Interface for creating Role instances.
 */
interface RoleFactoryInterface
{
    /**
     * Retrieves a role instance by name.
     *
     * @param string $name The name of the role to retrieve.
     * @return Role|null A Role instance if found, null otherwise.
     */
    public function getRole(string $name): ?Role;
}
