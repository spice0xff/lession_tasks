<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;
use App\Services\TestBasicService;

/**
 * @method static getBodyFromController()
 * @method static setBodyFromController($name, $age, $flag)
 * @see \App\Services\TestBasicService
 */
class TestBasicServiceFacade  extends Facade {
    protected static function getFacadeAccessor() {
        return 'service.TestBasicService';
    }
}
