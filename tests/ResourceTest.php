<?php

namespace ColeoTest\Auth;

use Coleo\Auth\Resource;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    public function testGetName()
    {
        $resource = new Resource('document', ['read', 'write']);
        $this->assertEquals('document', $resource->getName());
    }

    public function testGetAcceptablePermissions()
    {
        $resource = new Resource('document', ['read', 'write']);
        $this->assertEquals(['read', 'write'], $resource->getAcceptablePermissions());
    }
}
