<?php

namespace App\Services\TestBasicService;

class TestOne
{
    private $name = null;
    private $age = null;
    private $flag = null;

    public function __construct($name, $age, $flag)
    {
        $this->name = $name;
        $this->age = $age;
        $this->flag = $flag;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    public function getProperties()
    {
        return [
            "name" => $this->name,
            "age" => $this->age,
            "flag" => $this->flag
        ];
    }
}