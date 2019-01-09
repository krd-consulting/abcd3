<?php

namespace App\Providers;

use App\FileType;
use App\Program;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(FileType $fileTypes, Program $programs)
    {
        View::composer('*', function($view) use ($fileTypes, $programs) {
            if(Auth::check()) {
                $view->with('fileTypes', $fileTypes::all());

                $view->with(
                    'programs',
                    Auth::user()->availablePrograms(4)->get()
                );

                $view->with(
                    'teams',
                    Auth::user()->availableTeams
                );
            }
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
