<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Container\Container;

use App\Services\TestBasicService;
use App\Services\TestOne;

use App\Facades\TestBasicServiceFacade;

use App\Models\Test;


class TestController extends Controller
{
    protected $testBasicService;

    public function __construct(TestBasicService $testBasicService) {
        $this->testBasicService = $testBasicService;
    }

    public function getOne() {
//        $this->testBasicService = Container::getInstance()->make(TestBasicService::class);
//        $properties = $this->testBasicService->getProperties();

        $properties = TestBasicServiceFacade::getProperties();

        $json_response = json_encode($properties);
        echo $json_response;
    }

    public function setOne(Request $request) {
        $request_data = $request->all();

        $name = $request_data["name"];
        $age = $request_data["age"];
        $flag = $request_data["flag"];

//        $this->testBasicService = Container::getInstance()->make(TestBasicService::class);
        TestBasicServiceFacade::setProperties($name, $age, $flag);

        $properties = TestBasicServiceFacade::getProperties();
        $json_response = json_encode($properties);
        echo $json_response;
    }

    public function getRowById(Request $request)
    {
        return Test::getRowById($request->id);
    }
    public function getRowByText(Request $request)
    {
        return Test::getRowByText($request->text);
    }

    public function Test200(Request $request)
    {
        return response("my first test", 200);
    }
}
