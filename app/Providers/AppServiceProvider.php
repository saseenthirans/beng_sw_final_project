<?php

namespace App\Providers;

use App\Models\Company;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'layouts.admin_staff',
            function ($view) {
                $company = Company::find(1);
                $view->with('company', $company);
            }
        );

        view()->composer(
            'layouts.mail',
            function ($view) {
                $company = Company::find(1);
                $view->with('company', $company);
            }
        );
    }
}
