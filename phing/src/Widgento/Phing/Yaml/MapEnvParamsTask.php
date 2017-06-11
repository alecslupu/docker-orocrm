<?php

namespace Widgento\Phing\Yaml;

use Widgento\Phing\FileFactory;
use Widgento\Phing\Yaml\MapEnvParams\Param;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class MapEnvParamsTask extends \Task
{
    const YAML_PARAMETERS = 'parameters';

    /**
     * @var string
     */
    private $file;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @throws ParseException
     */
    public function main()
    {
        $yamlFile         = FileFactory::create($this->getFile())->openFile('r');
        $fileContents     = $yamlFile->fread($yamlFile->getSize());
        $inputParameters  = Yaml::parse($fileContents, true);

        $outputParameters = $this->updateEnvParams($inputParameters);

        FileFactory::create($this->getFile())
            ->openFile('w')
            ->fwrite(Yaml::dump($outputParameters));
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setFile($value)
    {
        $this->file = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    public function addComposerMapEnvParam(Param $param)
    {
        $this->params[] = $param;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    public function updateEnvParams(array $yamlParams)
    {
        /* @var $param Param */
        foreach ($this->getParams() as $param) {
            $yamlValue = null;
            if ($param->getValue()) {
                $yamlValue = $param->getValue();
            }

            $yamlParams[self::YAML_PARAMETERS][$param->getName()] = $yamlValue;
        }

        return $yamlParams;
    }
}
