<?php

namespace Coleo\Auth\JWT;

use Coleo\Auth\AuthContainerInterface;
use Coleo\Auth\AuthInterface;

class JWTAuth implements AuthInterface
{
    public function login(string $username, string $password): AuthContainerInterface|null
    {

    }

    public function logout(): bool
    {

    }
}