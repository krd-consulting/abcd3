<?php

namespace App\Providers;

use App\Program;
use App\ProgramClient;
use App\RecordType;
use App\Team;
use App\FormField;

use App\Observers\ProgramClientObserver;
use App\Observers\FormFieldObserver;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

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

        FormField::observe(FormFieldObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blueprint::macro('byAttributes', function () {
            $this->bigInteger('created_by')->unsigned();
            $this->bigInteger('updated_by')->unsigned();

            $this->foreign('created_by')->references('id')->on('users');
            $this->foreign('updated_by')->references('id')->on('users');
        });
    }
}
