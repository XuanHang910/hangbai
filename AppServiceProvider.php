<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        'App\Services\Interfaces\UserServiceInterface'=>'App\Services\UserService',
        'App\Repositories\Interfaces\UserRepositoryInterface'=>'App\Repositories\UserRepository',
        
        
        'App\Services\Interfaces\UserGroupMemberServiceInterface'=>'App\Services\UserGroupMemberService',
        'App\Repositories\Interfaces\UserGroupMemberRepositoryInterface'=>'App\Repositories\UserGroupMemberRepository',



        'App\Repositories\Interfaces\ProvinceRepositoryInterface'=>
        'App\Repositories\ProvinceRepository',
        'App\Repositories\Interfaces\DistrictRepositoryInterface'=>
        'App\Repositories\DistrictRepository',
    ];


    public function register(): void
    {
        foreach($this ->bindings as $key => $val)
        {
            $this->app->bind($key, $val);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
