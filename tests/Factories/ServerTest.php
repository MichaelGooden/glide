<?php

namespace League\Glide\Factories;

use League\Glide\Manipulators\Size as SizeManipulator;
use Mockery;

class ServerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateServer()
    {
        $this->assertInstanceOf('League\Glide\Factories\Server', new Server([]));
    }

    public function testGetServer()
    {
        $server = new Server([
            'source' => Mockery::mock('League\Flysystem\FilesystemInterface'),
            'cache' => Mockery::mock('League\Flysystem\FilesystemInterface'),
        ]);

        $this->assertInstanceOf('League\Glide\Server', $server->getServer());
    }

    public function testGetSource()
    {
        $server = new Server([
            'source' => Mockery::mock('League\Flysystem\FilesystemInterface'),
        ]);

        $this->assertInstanceOf('League\Flysystem\FilesystemInterface', $server->getSource());
    }

    public function testGetCache()
    {
        $server = new Server([
            'cache' => Mockery::mock('League\Flysystem\FilesystemInterface'),
        ]);

        $this->assertInstanceOf('League\Flysystem\FilesystemInterface', $server->getCache());
    }

    public function testGetApi()
    {
        $server = new Server([]);

        $this->assertInstanceOf('League\Glide\Api', $server->getApi());
    }

    public function testGetImageManager()
    {
        $server = new Server([
            'driver' => 'imagick',
        ]);

        $this->assertEquals('imagick', $server->getImageManager()->config['driver']);
    }

    public function testGetSignKey()
    {
        $server = new Server([
            'sign_key' => 'example',
        ]);

        $this->assertInstanceOf('League\Glide\SignKey', $server->getSignKey());
    }

    public function testGetManipulators()
    {
        $server = new Server([]);

        $this->assertInternalType('array', $server->getManipulators());
    }

    public function testGetManipulatorsWithMaxImageSize()
    {
        $server = new Server([
            'max_image_size' => 2000*2000,
        ]);

        $sizeManipulator = null;

        foreach ($server->getManipulators() as $manipulator) {
            if ($manipulator instanceof SizeManipulator) {
                $sizeManipulator = $manipulator;
            }
        }

        $this->assertInstanceOf('League\Glide\Manipulators\Size', $sizeManipulator);
        $this->assertEquals(2000*2000, $sizeManipulator->getMaxImageSize());
    }

    public function testCreate()
    {
        $server = Server::create([
            'source' => Mockery::mock('League\Flysystem\FilesystemInterface'),
            'cache' => Mockery::mock('League\Flysystem\FilesystemInterface'),
        ]);
        $this->assertInstanceOf('League\Glide\Server', $server);
    }
}
