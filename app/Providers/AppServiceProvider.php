<?php

namespace App\Providers;

use App\Models\Category;
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

        view()->composer(
            'layouts.home',
            function ($view) {
                $company = Company::find(1);
                $categories = Category::where('status',1)->orderBy('name','ASC')->take(11)->get();
                $categories_count = Category::where('status',1)->count();

                $view->with([
                    'company'=> $company,
                    'categories' => $categories,
                    'categories_count' => $categories_count
                ]);


            }
        );


    }
}
