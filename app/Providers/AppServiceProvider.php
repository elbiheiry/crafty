<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Support\Facades\URL;
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
        URL::forceScheme('https');    
        
        if (!app()->runningInConsole()) {
            view()->share([
                'settings' => Setting::FirstOrFail(),
                'links' => SocialLink::all()->sortByDesc('id')
            ]);
        }
    }
}
