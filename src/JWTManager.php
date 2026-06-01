<?php

namespace Coleo\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTManager implements JWTManagerInterface
{
    private $secretKey;
    private $algorithm;

    public function __construct($secretKey, $algorithm = 'HS256')
    {
        $this->secretKey = $secretKey;
        $this->algorithm = $algorithm;
    }

    public function issue(array $payload): string
    {
        return JWT::encode($payload, $this->secretKey, $this->algorithm);
    }

    public function verify(string $token): object|bool
    {
        try {
            return JWT::decode($token, new Key($this->secretKey, $this->algorithm));
        } catch (\Exception $e) {
            return false;
        }
    }

    public function revoke(string $token): bool
    {
        // Implement token revocation logic here if needed
        return true; // Placeholder
    }

    public function refresh(string $token): string|bool
    {
        $decoded = $this->verify($token);
        if ($decoded) {
            unset($decoded->exp); // Remove expiration time to create a new token
            return JWT::encode($decoded, $this->secretKey, $this->algorithm);
        }
        return false;
    }
}
