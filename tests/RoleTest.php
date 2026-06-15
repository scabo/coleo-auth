<?php

namespace ColeoTest\Auth;

use Coleo\Auth\Resource;
use Coleo\Auth\Role;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    public function testGetName()
    {
        $role = new Role('editor');
        $this->assertEquals('editor', $role->getName());
    }

    public function testSetPermissionsAndGetPermissions()
    {
        $resource = new Resource('document', ['read', 'write']);
        $role = (new Role('editor'))->setPermissions($resource, ['read']);

        $permissions = $role->getPermissions($resource);
        $this->assertEquals(['read'], $permissions);

        $role->setPermissions($resource, ['read', 'write']);
        $permissions = $role->getPermissions($resource);
        $this->assertEquals(['read', 'write'], $permissions);
    }

    public function testGetPermissionsForNonExistentResource()
    {
        $role = new Role('editor');
        $resource = new Resource('document', ['read', 'write']);

        $permissions = $role->getPermissions($resource);
        $this->assertEquals([], $permissions);
    }
}
