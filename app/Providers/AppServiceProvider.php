<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Auth\Notifications\ResetPassword::createUrlUsing(fn($user,$token)=>rtrim(config('app.url'),'/').'/reset-password.php?'.http_build_query(['token'=>$token,'email'=>$user->getEmailForPasswordReset()]));
        if (getenv('VERCEL')) \Illuminate\Support\Facades\URL::forceScheme('https');
    }
}
