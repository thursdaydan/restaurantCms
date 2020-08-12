<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Blade;
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
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        view()->composer('web.backend.layouts.app', static function ($view) {
            switch (config('app.env')) {
                case 'local':
                    $skin = 'navbar-danger';
                    break;

                case 'staging':
                    $skin = 'navbar-purple';
                    break;

                default:
                    $skin = 'navbar-primary';
                    break;
            }

            $view->with(compact('skin'));
        });

        Blade::directive('required', static function () {
            return '<span class="required">*</span>';
        });
    }
}
