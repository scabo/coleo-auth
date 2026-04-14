<?php

namespace Coleo\Auth;

/**
 * Interface for managing authentication data storage and retrieval.
 */
interface AuthContainerInterface
{
    /**
     * Stores data in the container.
     *
     * @param mixed $data The data to store.
     */
    public function store($data);

    /**
     * Retrieves data from the container.
     *
     * @return mixed The retrieved data, or null if no data is found.
     */
    public function retrieve();

    /**
     * Clears all data from the container.
     */
    public function clear();
}
