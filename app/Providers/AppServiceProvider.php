<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

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
        Inertia::share([
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessage()
                    :  (object)[];
            }
        ]);
        Inertia::share('flash', function () {
            return [
                'message' => Session::get('message'),
                'success' => Session::get('success'),
                'error' => Session::get('error'),
            ];
        });
    }
}
