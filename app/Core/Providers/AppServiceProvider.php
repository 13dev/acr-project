<?php

namespace App\Core\Providers;

use App\Core\Services\Youtube\YoutubeDownload;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(YoutubeDownload::class, function ($app, $param) {
            return new YoutubeDownload($param);
        });
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
