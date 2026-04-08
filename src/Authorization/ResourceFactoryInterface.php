<?php

namespace Coleo\Auth\Authorization;

interface ResourceFactoryInterface
{
    /**
     * Gets a resource by its name.
     *
     * @param string $name The unique identifier of the desired resource
     *  instance to retrieve. Must be valid and non-null.
     * @return \Coleo\Auth\Authorization\ResourceInterface Returns an object
     *  implementing ResourceInterface that represents this particular resource,
     *  or null if it cannot not found under a given name.
     */
    public function get($name): ?ResourceInterface;
}
