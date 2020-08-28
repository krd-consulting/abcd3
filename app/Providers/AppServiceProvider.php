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
                // Get people record types.
                $view->with('people', $recordTypes::whereHas('identity', function($query) {
                    $query->where('name', '!=', 'Other');
                })->get());

                // Get other record types.
                $view->with('other', $recordTypes::whereHas('identity', function($query) {
                    $query->where('name', 'Other');
                })->get());

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
        Blueprint::macro('userstamps', function () {
            $this->bigInteger('created_by')->unsigned()->nullable();
            $this->bigInteger('updated_by')->unsigned()->nullable();
            $this->bigInteger('deleted_by')->unsigned()->nullable();

            $this->foreign('created_by')->references('id')->on('users');
            $this->foreign('updated_by')->references('id')->on('users');
            $this->foreign('deleted_by')->references('id')->on('users');
        });
    }
}
