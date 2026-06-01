<?php

namespace Coleo\Auth\Tests;

use Coleo\Auth\JWTManager;
use Firebase\JWT\Key;
use PHPUnit\Framework\TestCase;

class JWTManagerTest extends TestCase
{
    private $jwtManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jwtManager = new JWTManager('MNRLKZetDMFeJ4rHQHfwjsqcLJqtiOa9MJbaaytCWQo=');
    }

    public function testIssueToken()
    {
        $payload = ['user_id' => 123, 'username' => 'testuser'];
        $token = $this->jwtManager->issue($payload);
        $decoded = $this->jwtManager->verify($token);

        $this->assertIsString($token);
        $this->assertInstanceOf(\stdClass::class, $decoded);
        $this->assertEquals($payload['user_id'], $decoded->user_id);
        $this->assertEquals($payload['username'], $decoded->username);
    }

    public function testVerifyToken()
    {
        $payload = ['user_id' => 123, 'username' => 'testuser'];
        $token = $this->jwtManager->issue($payload);

        $decoded = $this->jwtManager->verify($token);
        $this->assertInstanceOf(\stdClass::class, $decoded);
        $this->assertEquals($payload['user_id'], $decoded->user_id);
        $this->assertEquals($payload['username'], $decoded->username);

        $invalidToken = 'invalid_token';
        $result = $this->jwtManager->verify($invalidToken);
        $this->assertFalse($result);
    }

    public function testRevokeToken()
    {
        // Placeholder for token revocation tests
        $this->assertTrue(true); // Replace with actual implementation and assertions
    }

    public function testRefreshToken()
    {
        $payload = ['user_id' => 123, 'username' => 'testuser'];
        $token = $this->jwtManager->issue($payload);

        $newToken = $this->jwtManager->refresh($token);
        $decoded = $this->jwtManager->verify($newToken);

        $this->assertIsString($newToken);
        $this->assertInstanceOf(\stdClass::class, $decoded);
        $this->assertEquals($payload['user_id'], $decoded->user_id);
        $this->assertEquals($payload['username'], $decoded->username);
    }
}
