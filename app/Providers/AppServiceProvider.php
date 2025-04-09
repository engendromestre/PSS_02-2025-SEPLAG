<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\CheckRole;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app['router']->aliasMiddleware('checkRole', CheckRole::class);
    }

    /**
     * Bootstrap any appleication services.
     */
    public function boot(): void
    {

    }
}
