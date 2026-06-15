<?php

namespace ColeoTest\Auth;

use Coleo\Auth\ArrayResourceFactory;
use Coleo\Auth\Resource;
use PHPUnit\Framework\TestCase;

class ArrayResourceFactoryTest extends TestCase
{
    public function testGetResourceWithValidName()
    {
        $resourceMap = [
            'document' => ['read', 'write'],
            'image' => ['view']
        ];
        $factory = new ArrayResourceFactory($resourceMap);

        $resource = $factory->getResource('document');
        $this->assertInstanceOf(Resource::class, $resource);
        $this->assertEquals('document', $resource->getName());
        $this->assertEquals(['read', 'write'], $resource->getAcceptablePermissions());
    }

    public function testGetResourceWithInvalidName()
    {
        $resourceMap = [
            'document' => ['read', 'write'],
            'image' => ['view']
        ];
        $factory = new ArrayResourceFactory($resourceMap);

        $resource = $factory->getResource('video');
        $this->assertNull($resource);
    }

    public function testGetResourceWithEmptyPermissions()
    {
        $resourceMap = [
            'document' => []
        ];
        $factory = new ArrayResourceFactory($resourceMap);

        $resource = $factory->getResource('document');
        $this->assertInstanceOf(Resource::class, $resource);
        $this->assertEquals('document', $resource->getName());
        $this->assertEquals([], $resource->getAcceptablePermissions());
    }

    public function testGetResourceWithNullPermissions()
    {
        $resourceMap = [
            'document' => null
        ];
        $factory = new ArrayResourceFactory($resourceMap);

        $resource = $factory->getResource('document');
        $this->assertNull($resource);
    }

    public function testGetResourceWithNonArrayPermissions()
    {
        $resourceMap = [
            'document' => 'read'
        ];
        $factory = new ArrayResourceFactory($resourceMap);

        $resource = $factory->getResource('document');
        $this->assertNull($resource);
    }
}
