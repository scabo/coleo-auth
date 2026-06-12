<?php

namespace Coleo\Auth;

interface AuthenticatorInterface
{
    public function login(string $email, $password, bool $rememberMe = false);

    public function isAuthenticated(): bool;

    public function getLoggedUser(): array|bool;

    public function logout();
}