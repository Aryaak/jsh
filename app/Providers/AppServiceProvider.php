<?php

namespace App\Providers;

use App\Models\Branch;
use Illuminate\Support\Facades\Schema;
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
        view()->composer(['designs.*', 'layout.*', 'master.*', 'payment.*', 'product.*', 'report.*', 'dashboard', 'regionals', 'branches', 'profile','expenses','surety-bonds-client','surety-bonds-draft','guarantee-banks-draft','guarantee-banks-client','datatables.actions-products'], function ($view) {
            $currently_on = 'main';
            if (request()->routeIs('regional.*')) $currently_on = 'regional';
            elseif (request()->routeIs('branch.*')) $currently_on = 'branch';
            elseif (request()->routeIs('design.*')) $currently_on = 'design';
            $global['currently_on'] = $currently_on;

            if ($currently_on == 'regional' || $currently_on == 'branch') {
                $slug = explode('/', url()->current())[3];
                if (! session()->has('regional') || session('regional')?->slug != $slug) {
                    session()->put('regional', Branch::where('slug', $slug)->first());
                }
                $global['regional'] = session()->get('regional');
            }
            if ($currently_on == 'branch') {
                $slug = explode('/', url()->current())[4];
                if (! session()->has('branch') || session('branch')?->slug != $slug) {
                    session()->put('branch', Branch::where('slug', $slug)->first());
                }
                $global['branch'] = session()->get('branch');
            }

            $view->with('global', (object)$global);
        });

        Schema::defaultStringLength(191);
    }
}
