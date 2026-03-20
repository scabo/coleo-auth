<?php

declare(strict_types=1);

namespace Coleo\Auth;

interface TokenServiceInterface
{
    public function generate(array $payload): array;

    public function decode(string $token): array;

    public function refresh(string $token): array;
}