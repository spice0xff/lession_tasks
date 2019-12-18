<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\TestBasicService;
use App\Services\TestOne;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TestBasicService::class, function ()   {
            return new TestBasicService(new TestOne());
        });
        $this->app->alias(TestBasicService::class, 'service.TestBasicService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
