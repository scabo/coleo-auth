<?php

namespace Coleo\Auth\Authorization\Tests;

use Coleo\Auth\Authorization\Resource;
use Coleo\Auth\Authorization\ManagerInterface;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = $this->createMock(ManagerInterface::class);
        $this->resource = new Resource('test_resource', $this->manager);
    }

    public function testGetName()
    {
        $this->assertEquals('test_resource', $this->resource->getName());
    }

    public function testAllowedWithValidPermissions()
    {
        $this->manager
            ->method('getResourcePermissions')
            ->with('test_resource')
            ->willReturn(['read', 'write']);

        $this->assertTrue($this->resource->allowed('user', ['read']));
        $this->assertTrue($this->resource->allowed(['admin'], ['write']));
    }

    public function testAllowedWithInvalidPermissions()
    {
        $this->manager
            ->method('getResourcePermissions')
            ->with('test_resource')
            ->willReturn(['read']);

        $this->expectException(\InvalidArgumentException::class);
        $this->resource->allowed('user', ['write']);
    }

    public function testDeniedWithValidPermissions()
    {
        $this->manager
            ->method('getResourcePermissions')
            ->with('test_resource')
            ->willReturn(['read', 'write']);

        $this->assertFalse($this->resource->denied('user', ['write']));
        $this->assertFalse($this->resource->denied(['admin'], ['read']));
    }

    public function testDeniedWithInvalidPermissions()
    {
        $this->manager
            ->method('getResourcePermissions')
            ->with('test_resource')
            ->willReturn(['read']);

        $this->assertTrue($this->resource->denied('user', ['write']));
    }

    public function testGetPermissions()
    {
        $this->manager
            ->method('getResourcePermissions')
            ->with('test_resource')
            ->willReturn(['read', 'write']);

        $this->assertEquals(['read', 'write'], $this->resource->getPermissions());
    }
}
