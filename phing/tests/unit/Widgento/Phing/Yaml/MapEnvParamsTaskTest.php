<?php

namespace tests\unit\Widgento\Phing\Yaml;

use Widgento\Phing\FileFactory;
use Widgento\Phing\Yaml\MapEnvParams\Param;
use Widgento\Phing\Yaml\MapEnvParamsTask;
use SplFileObject;
use Symfony\Component\Yaml\Yaml;
use Mockery;

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
        $this->assertSame($this->mapEnvParamsTask, $this->mapEnvParamsTask->setFile($fileName));
        $this->assertEquals($fileName, $this->mapEnvParamsTask->getFile());
    }

    public function testParams()
    {
        $params = [
            $this->createMock(Param::class),
            $this->createMock(Param::class),
        ];

        foreach ($params as $param) {
            $this->assertSame($this->mapEnvParamsTask, $this->mapEnvParamsTask->addComposerMapEnvParam($param));
        }

        $this->assertEquals($params, $this->mapEnvParamsTask->getParams());
    }

    public function testMain()
    {
        $fileReadSize      = 100;
        $fileReadContents  = 'blablabal';
        $fileWriteContents = 'blablabal updated';
        $fileParameters    = [
            MapEnvParamsTask::YAML_PARAMETERS => [
                'database_driver' => 'default',
                'something'       => 'else',
            ],
        ];
        $expectedParameters  = [
            MapEnvParamsTask::YAML_PARAMETERS => [
                'database_driver' => 'new_driver',
                'something'       => 'else',
                'database_port'   => null,
            ],
        ];
        $replacedParamsValues = [
            0 => ['name' => 'database_driver', 'value' => 'new_driver'],
            1 => ['name' => 'database_port', 'value' => ''],
        ];

        $replacedParams = [
            0 => $this->createMock(Param::class),
            1 => $this->createMock(Param::class),
        ];

        $replacedParams[0]
            ->expects($this->exactly(2))
            ->method('getValue')
            ->willReturn($replacedParamsValues[0]['value']);

        $replacedParams[1]
            ->expects($this->once())
            ->method('getValue')
            ->willReturn($replacedParamsValues[1]['value']);

        foreach ($replacedParams as $i => $replacedParam) {
            $this->mapEnvParamsTask->addComposerMapEnvParam($replacedParam);

            $replacedParams[$i]
                ->expects($this->once())
                ->method('getName')
                ->willReturn($replacedParamsValues[$i]['name']);
        }

        $fileFactoryMock = Mockery::mock('alias:'.FileFactory::class);
        $fileReadMock    = Mockery::mock(SplFileObject::class, ['php://memory']);

        $fileFactoryMock
            ->shouldReceive('create')
            ->times(1)
            ->andReturn($fileReadMock);

        $fileReadMock
            ->shouldReceive('openFile')
            ->with('r')
            ->times(1)
            ->andReturn($fileReadMock);

        $fileReadMock
            ->shouldReceive('getSize')
            ->times(1)
            ->andReturn($fileReadSize);

        $fileReadMock
            ->shouldReceive('fread')
            ->with($fileReadSize)
            ->times(1)
            ->andReturn($fileReadContents);

        $yamlMock = Mockery::mock('alias:'.Yaml::class);

        $yamlMock
            ->shouldReceive('parse')
            ->with($fileReadContents, true)
            ->times(1)
            ->andReturn($fileParameters);

        $yamlMock
            ->shouldReceive('dump')
            ->with($expectedParameters)
            ->times(1)
            ->andReturn($fileWriteContents);

        $fileWriteMock = Mockery::mock(SplFileObject::class, ['php://memory']);

        $fileFactoryMock
            ->shouldReceive('create')
            ->times(1)
            ->andReturn($fileWriteMock);

        $fileWriteMock
            ->shouldReceive('openFile')
            ->with('w')
            ->times(1)
            ->andReturn($fileWriteMock);

        $fileWriteMock
            ->shouldReceive('fwrite')
            ->with($fileWriteContents)
            ->times(1);

        $this->mapEnvParamsTask->main();
    }
}