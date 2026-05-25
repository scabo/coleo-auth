<?php

namespace Coleo\Auth\JWT;

interface JWTServiceInerface
{
    public function generateToken();
    public function verifyToken();
    
}