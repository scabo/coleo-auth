<?php

/**
 * Interface for creating Resource instances.
 */
interface ResourceFactoryInterface
{
    /**
     * Retrieves a resource instance by name.
     *
     * @param string $name The name of the resource to retrieve.
     * @return Resource|null A Resource instance if found, null otherwise.
     */
    public function getResource(string $name): ?Resource;
}
