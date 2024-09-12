<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind('path.public', function () {

            return base_path() . '/public_html';

        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('api', function ($data, $status_code) {
            return response()->json([
                'data' => $data,
            ], $status_code);
        });

        Response::macro('apiError', function ($error, $status_code) {
            return response()->json([
                'success' => false,
                'error' => $error,
            ], $status_code);
        });

    }
}
