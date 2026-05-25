<?php

namespace ColeoTest\Auth\Authorization;


use Coleo\Auth\Authorization\ArrayConfigManager;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class ArrayConfigManagerTest extends TestCase
{
    private $fs;

    protected function setUp(): void
    {
        $this->fs = vfsStream::setup();
    }
    

    /** @test */
    public function test_missing_config_file()
    {
        $path = vfsStream::url($this->fs->path() . '/auth.config.php');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Configuration file {$path} does not exist.");
        new ArrayConfigManager($path);
    }

    /** @test */
    public function test_existing_empty_config_file()
    {
        $path = vfsStream::url($this->fs->path() . '/auth.config.php');
        touch($path);

        $this->expectExceptionMessage("Failed to parse configuration file: format does not match expected schema.");
        new ArrayConfigManager($path);
    }
    
    public function test_existing_incorrect_config_file()
    {
        $path = vfsStream::url($this->fs->path() . '/auth.config.php');
        
        $auth = ["some" => "weird"];
        $content = "<?php\nreturn " . var_export($auth, true) . ";";
        file_put_contents($path, $content);

        $this->expectExceptionMessage("Failed to parse configuration file: format does not match expected schema.");
        new ArrayConfigManager($path);
    }

    public function test_correct_config_file_has_roles()
    {
        $path = vfsStream::url($this->fs->path() . '/auth.config.php');
        
        $auth = [
            "roles" => [
                "free_user" => [
                    "dashboard" => ["view"]
                ],
                "premium_user" => [
                    "dashboard" => ["view", "edit"]
                ],
                "guest" => []
            ],
            "resources" => [
                "dashboard" => ["view", "edit"]
            ]
        ];

        $content = "<?php\nreturn " . var_export($auth, true) . ";";
        file_put_contents($path, $content);

        $manager = new ArrayConfigManager($path);
        $roles = $manager->getRoles();
        $this->assertIsArray($roles);

        $expectedRoles = ["free_user", "premium_user", "guest"];
        foreach ($expectedRoles as $expectedRole) {
            $this->assertArrayHasKey($expectedRole, $roles);
        }
    }
}