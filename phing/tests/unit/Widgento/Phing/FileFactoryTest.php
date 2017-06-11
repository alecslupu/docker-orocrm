<?php

namespace tests\unit\Widgento\Phing;

use Widgento\Phing\FileFactory;
use SplFileObject;

class FileFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateNotExisting()
    {
        $this->expectException(\Exception::class);
        $fileName = '/not/existing/file';
        FileFactory::create($fileName);
    }

    public function testCreate()
    {
        $fileName = '/etc/passwd';
        $this->assertInstanceOf(SplFileObject::class, FileFactory::create($fileName));
    }
}