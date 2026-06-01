<?php

namespace Coleo\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * JWTManager is responsible for managing JSON Web Tokens (JWTs).
 */
class JWTManager implements JWTManagerInterface
{
    /**
     * The secret key used to encode and decode JWTs.
     *
     * @var string
     */
    private $secretKey;

    /**
     * The algorithm used for encoding and decoding JWTs.
     *
     * @var string
     */
    private $algorithm;

    /**
     * Constructs a new JWTManager instance with the specified secret key and algorithm.
     *
     * @param string $secretKey The secret key to use for JWT encoding and decoding.
     * @param string $algorithm The algorithm to use for JWT encoding and decoding (default is 'HS256').
     */
    public function __construct($secretKey, $algorithm = 'HS256')
    {
        $this->secretKey = $secretKey;
        $this->algorithm = $algorithm;
    }

    /**
     * Issues a new JWT with the given payload.
     *
     * @param array $payload The payload to encode into the JWT.
     * @return string The encoded JWT.
     */
    public function issue(array $payload): string
    {
        return JWT::encode($payload, $this->secretKey, $this->algorithm);
    }

    /**
     * Verifies and decodes a JWT.
     *
     * @param string $token The JWT to verify and decode.
     * @return object|bool The decoded payload if the token is valid, or false otherwise.
     */
    public function verify(string $token): object|bool
    {
        try {
            return JWT::decode($token, new Key($this->secretKey, $this->algorithm));
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Revokes a JWT (placeholder implementation).
     *
     * @param string $token The JWT to revoke.
     * @return bool True if the token is successfully revoked, or false otherwise.
     */
    public function revoke(string $token): bool
    {
        // Implement token revocation logic here if needed
        return true; // Placeholder
    }

    /**
     * Refreshes a JWT by removing its expiration time and encoding it again.
     *
     * @param string $token The JWT to refresh.
     * @return string|bool A new JWT with refreshed expiration, or false if the token is invalid.
     */
    public function refresh(string $token): string|bool
    {
        $decoded = $this->verify($token);
        if ($decoded) {
            unset($decoded->exp); // Remove expiration time to create a new token
            return JWT::encode((array) $decoded, $this->secretKey, $this->algorithm);
        }
        return false;
    }
}
