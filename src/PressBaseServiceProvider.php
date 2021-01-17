<?php


namespace amirgonvt\Press;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use amirgonvt\Press\Facades\Press;

class PressBaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
        $this->registerResources();
    }

    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/press.php' => config_path('press.php'),
        ], 'press-config');
    }

    /**
     * Register all of the package resources here
     */
    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'press');

        $this->registerFacades();
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * Routes configuration will set from here.
     *
     * @return array
     */
    private function routeConfiguration():array
    {
        return [
            'prefix' => Press::path(),
            'namespace' => 'amirgonvt\Press\Http\Controllers',
        ];
    }

    public function register()
    {
        $this->commands([
            Console\ProcessCommand::class,
        ]);
    }

    protected function registerFacades()
    {
        $this->app->singleton('Press', function ($app) {
            return new \amirgonvt\Press\Press();
        });
    }
}