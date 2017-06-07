<?php

namespace tests\unit\Widgento\Phing\Yaml;

use Widgento\Phing\Yaml\MapEnvParams\Param;
use Widgento\Phing\Yaml\MapEnvParamsTask;

class MapEnvParamsTaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MapEnvParamsTask
     */
    private $mapEnvParamsTask;

    public function setUp()
    {
        $this->mapEnvParamsTask = new MapEnvParamsTask();
    }

    public function testFile()
    {
        $fileName = '/path/to/file';
        $this->assertEmpty($this->mapEnvParamsTask->getFile());
        $this->mapEnvParamsTask->setFile($fileName);
        $this->assertEquals($fileName, $this->mapEnvParamsTask->getFile());
    }

    public function testParams()
    {
        $params = [
            $this->createMock(Param::class),
            $this->createMock(Param::class),
        ];

        foreach ($params as $param) {
            $this->mapEnvParamsTask->addComposerMapEnvParam($param);
        }

        $this->assertEquals($params, $this->mapEnvParamsTask->getParams());
    }
}