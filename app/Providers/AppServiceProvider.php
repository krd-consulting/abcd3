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
    public function boot(RecordType $recordTypes, Program $programs, Team $teams)
    {
        View::composer('*', function($view) use ($recordTypes, $programs) {
            if(Auth::check()) {
                $view->with('recordTypes', $recordTypes::all());

                $view->with(
                    'programs',
                    $programs->availableFor(Auth::user())->get()
                );

                $view->with(
                    'teams',
                    //$teams->availableFor(Auth::user())
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
