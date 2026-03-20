<?php

declare(strict_types=1);

namespace Coleo\Auth;

interface TokenBearerInterface
{
    public function load(): string|null;
}