<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\FileType;
use App\Program;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(FileType $fileTypes, Program $programs )
    {
        // TODO: Remove this when policies/guards are being implemented.
        View::composer('*', function($view) use ($fileTypes, $programs) {
            if(Auth::check())
                $view->with('fileTypes', $fileTypes::all());
                $view->with('programs', $programs::all());
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
