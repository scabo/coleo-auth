<?php

namespace ColeoTest\Auth;

use Coleo\Auth\AccessCheck;
use Coleo\Auth\Resource;
use Coleo\Auth\Role;
use PHPUnit\Framework\TestCase;

class AccessCheckTest extends TestCase
{
    public function testIsAllowedWithValidPermissions()
    {
        $resource = new Resource('document', ['read', 'write']);
        $role = (new Role('editor'))->setPermissions($resource, ['read']);

        $accessCheck = new AccessCheck();
        $this->assertTrue($accessCheck->isAllowed($resource, $role, 'read'));
    }

    
    public function testIsAllowedWithMultipleValidPermissions()
    {
        $resource = new Resource('document', ['read', 'write']);
        $role = (new Role('editor'))->setPermissions($resource, ['read', 'write']);

        $accessCheck = new AccessCheck();
        $this->assertTrue($accessCheck->isAllowed($resource, $role, ['read', 'write']));
    }

    public function testIsAllowedWithInvalidPermission()
    {
        $resource = new Resource('document', ['read']);
        $role = (new Role('viewer'))->setPermissions($resource, ['read']);

        $accessCheck = new AccessCheck();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Passed permissions are incorrect");
        $accessCheck->isAllowed($resource, $role, 'write');
    }

    public function testIsAllowedWithNoPermissions()
    {
        $resource = new Resource('document', ['read']);
        $role = (new Role('viewer'));

        $accessCheck = new AccessCheck();
        $this->assertFalse($accessCheck->isAllowed($resource, $role, 'read'));
    }
    
    public function testIsAllowedWithEmptyPermissions()
    {
        $resource = new Resource('document', ['read']);
        $role = (new Role('viewer'))->setPermissions($resource, []);

        $accessCheck = new AccessCheck();
        $this->assertFalse($accessCheck->isAllowed($resource, $role, 'read'));
    }

    public function testIsAllowedWithSubsetOfPermissions()
    {
        $resource = new Resource('document', ['read', 'write']);
        $role = (new Role('editor'))->setPermissions($resource, ['read']);

        $accessCheck = new AccessCheck();
        $this->assertTrue($accessCheck->isAllowed($resource, $role, ['read']));
    }

    public function testIsAllowedWithNonExistentResource()
    {
        $resource = new Resource('document', ['read']);
        $role = (new Role('editor'))->setPermissions(new Resource('image', ['read']), ['read']);

        $accessCheck = new AccessCheck();
        $this->assertFalse($accessCheck->isAllowed($resource, $role, 'read'));
    }

    public function testIsAllowedWithInvalidPermissions()
    {
        $resource = new Resource('document', ['read']);
        $role = (new Role('editor'))->setPermissions($resource, ['read']);

        $accessCheck = new AccessCheck();
        $this->expectException(\InvalidArgumentException::class);
        $accessCheck->isAllowed($resource, $role, 'delete');
    }
}
