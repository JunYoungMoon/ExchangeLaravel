<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //스트릭트 모드 활성화 개발에서만 스트릭트 모드 활성화 해야한다.
        //파라미터를 true를 주면 활성화된다.
        if (config('app.env') === 'local' || config('app.env') === 'dev') {
            Model::shouldBeStrict();
        }
    }
}
