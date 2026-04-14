<?php

namespace Coleo\Auth;

/**
 * Interface for authentication operations.
 */
interface AuthInterface
{
    public function login(string $username, string $password): AuthContainerInterface|null;
    public function logout(): bool;
}
