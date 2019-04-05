<?php

namespace App\Providers;

use App\Program;
use App\RecordType;
use App\Team;

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
    public function boot(RecordType $recordTypes, Program $programs)
    {
        View::composer('*', function($view) use ($recordTypes, $programs) {
            if(Auth::check()) {
                $view->with('recordTypes', $recordTypes::all());

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
