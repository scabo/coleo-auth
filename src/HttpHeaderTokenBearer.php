<?php

declare(strict_types=1);

namespace Coleo\Auth;

class HttpHeaderTokenBearer implements TokenBearerInterface
{
    public function load(): string|null
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';

        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $matches[1];
        }

        return null;
    }
}