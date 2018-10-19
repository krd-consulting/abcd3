<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\FileType;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(FileType $fileTypes)
    {
        // TODO: Remove this when policies/guards are being implemented.
        View::composer('*', function($view) use ($fileTypes) {
            if(Auth::check())
                $view->with('fileTypes', $fileTypes::all());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
