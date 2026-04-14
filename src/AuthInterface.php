<?php

namespace Coleo\Auth;

// Add Comments. AI!
interface AuthInterface
{
    public function store();
    public function retrieve();
    public function reset();
}