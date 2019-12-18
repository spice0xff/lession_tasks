<?php

namespace App\Services;

class TestOne
{
    private $name = "Bob";
    private $age = 44;
    private $flag = true;

    public function __construct($name="", $age=0, $flag=True)
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

    public function setProperties($name="", $age=0, $flag=True)
    {
        $this->name = $name;
        $this->age = $age;
        $this->flag = $flag;
    }
}

