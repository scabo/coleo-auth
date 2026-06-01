<?php

namespace Coleo\Auth;

interface JWTManagerInterface
{
    public function issue(array $payload): string;
    public function verify(string $token): object|bool;
    public function revoke(string $token): bool;
    public function refresh(string $token): string|bool;
}