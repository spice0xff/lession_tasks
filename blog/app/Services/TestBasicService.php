<?php

namespace App\Services;

class TestBasicService
{
    private $testOne = null;

    public function __construct(TestOne $testOne)
    {
        $this->testOne = $testOne;
    }

    public function getProperties()
    {
        return $this->testOne->getProperties();
    }

    public function setProperties($name="", $age=0, $flag=True)
    {
        return $this->testOne->setProperties($name, $age, $flag);
    }
}
