<?php

namespace ColeoTest\Auth;

use Coleo\Auth\ArrayRoleFactory;
use Coleo\Auth\Resource;
use Coleo\Auth\ResourceFactoryInterface;
use Coleo\Auth\Role;
use PHPUnit\Framework\TestCase;

class ArrayRoleFactoryTest extends TestCase
{
    public function testGetRoleWithValidName()
    {
        $roleMap = [
            'editor' => [
                'document' => ['read', 'write']
            ],
            'viewer' => [
                'document' => ['read']
            ]
        ];

        $resourceFactory = $this->createMock(ResourceFactoryInterface::class);        
        $resourceFactory->method('getResource')->
            with('document')->
            willReturn(new Resource('document', ['read', 'write', 'delete']));

        $factory = new ArrayRoleFactory($roleMap, $resourceFactory);

        $role = $factory->getRole('editor');
        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals('editor', $role->getName());
    }

    public function testGetRoleWithInvalidName()
    {
        $roleMap = [
            'editor' => [
                'document' => ['read', 'write']
            ],
            'viewer' => [
                'document' => ['read']
            ]
        ];
        $factory = new ArrayRoleFactory($roleMap, $this->createMock(ResourceFactoryInterface::class));

        $role = $factory->getRole('admin');
        $this->assertNull($role);
    }

    public function testGetRoleWithEmptyPermissions()
    {
        $roleMap = [
            'editor' => []
        ];
        $factory = new ArrayRoleFactory($roleMap, $this->createMock(ResourceFactoryInterface::class));

        $role = $factory->getRole('editor');
        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals('editor', $role->getName());
    }

    public function testGetRoleWithNullPermissions()
    {
        $roleMap = [
            'editor' => null
        ];
        $factory = new ArrayRoleFactory($roleMap, $this->createMock(ResourceFactoryInterface::class));

        $role = $factory->getRole('editor');
        $this->assertNull($role);
    }

    public function testGetRoleWithNonArrayPermissions()
    {
        $roleMap = [
            'editor' => 'read'
        ];
        $factory = new ArrayRoleFactory($roleMap, $this->createMock(ResourceFactoryInterface::class));

        $role = $factory->getRole('editor');
        $this->assertNull($role);
    }
}
