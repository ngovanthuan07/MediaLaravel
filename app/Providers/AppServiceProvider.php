<?php

namespace App\Providers;

use App\Services\HeartService;
use App\Services\MemberService;
use App\Services\RoomDetailService;
use App\Services\RoomService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HeartService::class, function ($app) {
            return new HeartService();
        });
        $this->app->bind(MemberService::class, function ($app) {
            return new MemberService();
        });
        $this->app->bind(RoomService::class, function ($app) {
            return new RoomService();
        });
        $this->app->bind(RoomDetailService::class, function ($app) {
            return new RoomDetailService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
