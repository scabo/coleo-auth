<?php

namespace Coleo\Auth;

/**
 * Interface for authentication operations.
 */
interface AuthInterface
{
    /**
     * Logs in a user with the given username and password.
     *
     * @param string $username The username of the user to log in.
     * @param string $password The password of the user to log in.
     * @return AuthContainerInterface|null An instance of AuthContainerInterface if login is successful, null otherwise.
     */
    public function login(string $username, string $password): AuthContainerInterface|null;

    /**
     * Logs out the currently authenticated user.
     *
     * @return bool True if logout is successful, false otherwise.
     */
    public function logout(): bool;
}
