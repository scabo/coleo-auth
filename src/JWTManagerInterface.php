<?php

namespace Coleo\Auth;

/**
 * JWTManagerInterface defines methods for managing JSON Web Tokens (JWTs).
 */
interface JWTManagerInterface
{
    /**
     * Issues a new JWT with the given payload.
     *
     * @param array $payload The payload to encode into the JWT.
     * @return string The encoded JWT.
     */
    public function issue(array $payload): string;

    /**
     * Verifies and decodes a JWT.
     *
     * @param string $token The JWT to verify and decode.
     * @return object|bool The decoded payload if the token is valid, or false otherwise.
     */
    public function verify(string $token): object|bool;

    /**
     * Revokes a JWT (placeholder implementation).
     *
     * @param string $token The JWT to revoke.
     * @return bool True if the token is successfully revoked, or false otherwise.
     */
    public function revoke(string $token): bool;

    /**
     * Refreshes a JWT by removing its expiration time and encoding it again.
     *
     * @param string $token The JWT to refresh.
     * @return string|bool A new JWT with refreshed expiration, or false if the token is invalid.
     */
    public function refresh(string $token): string|bool;
}
