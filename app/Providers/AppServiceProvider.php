<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\FailedJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
