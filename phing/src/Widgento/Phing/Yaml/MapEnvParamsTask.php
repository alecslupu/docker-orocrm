<?php

namespace Widgento\Phing\Yaml;

use Widgento\Phing\Yaml\MapEnvParams\Param;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class MapEnvParamsTask extends \Task
{
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
        $inputParameters = Yaml::parse(file_get_contents($this->getFile()), true);

        $outputParameters = $this->updateEnvParams($inputParameters);

        file_put_contents($this->getFile(), Yaml::dump($outputParameters));
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

            $yamlParams['parameters'][$param->getName()] = $yamlValue;
        }

        return $yamlParams;
    }
}
