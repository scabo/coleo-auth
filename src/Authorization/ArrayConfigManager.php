<?php

namespace Coleo\Auth\Authorization;

use RuntimeException;

class ArrayConfigManager implements ManagerInterface
{
    private $config = [];

    public function __construct(private string $configPath)
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
            || !is_array($this->config['roles'])) {
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
    public function getResource(string $resource): ResourceInterface|null
    {
        if (isset($this->config["resources"][$resource])) {
            return new Resource($resource, $this);
        }
        
        return null;
    }
    

    public function getPermissions(string $role, string $resource): array
    {       
        if (isset($this->config["roles"][$role][$resource])) {
            return $this->config["roles"][$role][$resource];
        }
        
        return [];
    }
   
    /**
     * Undocumented function
     *
     * @param string $resource
     * @return array
     */
    public function getResourcePermissions(string $resource): array
    {
        if (isset($this->config["resources"][$resource])) {
            return $this->config["resources"][$resource];
        }
        
        return [];
    }
}