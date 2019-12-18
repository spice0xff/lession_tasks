<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\TestBasicService\TestOne;


class TestController extends Controller
{
    public function getOne() {
        $testOne = new TestOne("Bob", 44, true);
        $properties = $testOne->getProperties();

        $json_response = json_encode($properties);
        echo $json_response;
    }

    public function setOne(Request $request) {
        $request_data = $request->all();

        $name = $request_data["name"];
        $age = $request_data["age"];
        $flag = $request_data["flag"];

        $testOne = new TestOne($name, $age, $flag);
        $properties = $testOne->getProperties();

        $json_response = json_encode($properties);
        echo $json_response;
    }
}
