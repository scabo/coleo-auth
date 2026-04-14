<?php

namespace Coleo\Auth;

/**
 * Interface for authentication operations.
 */
interface AuthInterface
{
    /**
     * Stores authentication data.
     *
     * @return void
     */
    public function store();

    /**
     * Retrieves authentication data.
     *
     * @return mixed The retrieved authentication data or null if not found.
     */
    public function retrieve();

    /**
     * Resets the authentication state.
     *
     * @return void
     */
    public function reset();
}
