<?php

namespace Coleo\Auth;

/**
 * Interface for authenticating users.
 */
interface AuthenticatorInterface
{
    /**
     * Logs in a user with the given email and password.
     *
     * @param string $email The user's email address.
     * @param mixed $password The user's password.
     * @param bool $rememberMe Whether to remember the user's login.
     */
    public function login(string $email, $password, bool $rememberMe = false);

    /**
     * Checks if a user is currently authenticated.
     *
     * @return bool True if the user is authenticated, false otherwise.
     */
    public function isAuthenticated(): bool;

    /**
     * Retrieves the logged-in user's information.
     *
     * @return array|bool The user's information if authenticated, or false otherwise.
     */
    public function getLoggedUser(): array|bool;

    /**
     * Logs out the current user.
     */
    public function logout();
}
