<?php

namespace Widgento\Phing\Yaml\MapEnvParams;

class Param
{
    private $name;
    private $value;

    public function setName($value)
    {
        $this->name = $value;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }
}
