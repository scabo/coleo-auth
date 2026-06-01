<?php

namespace Coleo\Auth\Authorization;

use RuntimeException;

/**
 * Class ArrayConfigManager
 *
 * Manages authorization configuration using an array.
 */
class ArrayConfigManager implements ManagerInterface
{
    /**
     * @var array The configuration data.
     */
    private $config = [];

    /**
     * Constructs the ArrayConfigManager with a configuration file path.
     *
     * @param string $configPath The path to the configuration file.
     */
    public function __construct(string $configPath)
    {
        if (!file_exists($configPath) || !is_file($configPath)) {
            throw new RuntimeException("Configuration file {$configPath} does not exist.");
        }

        $this->config = require $configPath;
        if (
            !is_array($this->config)
            || !isset($this->config['resources'])
            || !is_array($this->config['resources'])
            || !isset($this->config['roles'])
            || !is_array($this->config['roles'])
        ) {
            throw new RuntimeException("Failed to parse configuration file: format does not match expected schema.");
        }
    }

    /**
     * Returns the resources.
     *
     * @return array
     */
    public function getResources(): array
    {
        return $this->config['resources'];
    }

    /**
     * Returns the roles.
     *
     * @return array
     */
    public function getRoles(): array
    {
        return $this->config['roles'];
    }

    /**
     * Retrieves a resource by its name.
     *
     * @param string $resource The name of the resource.
     * @return ResourceInterface|null The resource object, or null if not found.
     */
    public function getResource(string $resource): ResourceInterface|null
    {
        if (isset($this->config["resources"][$resource])) {
            return new Resource($resource, $this);
        }

        return null;
    }


    /**
     * Retrieves permissions for a role and resource.
     *
     * @param string $role The name of the role.
     * @param string $resource The name of the resource.
     * @return array An ar ay of permissions associated with the role and resource.
     */
    public function getPermissions(string $role, string $resource): array
    {
        if (isset($this->config["roles"][$role][$resource])) {
            return $this->config["roles"][$role][$resource];
        }

        return [];
    }

    /**
     * Retrieves all permissions for a resource.
     *
     * @param string $resource The name of the resource.
     * @return array An array of permissions associated with the resource.
     */
    public function getResourcePermissions(string $resource): array
    {
        if (isset($this->config["resources"][$resource])) {
            return $this->config["resources"][$resource];
        }

        return [];
    }
}
