<?php

namespace Victoranw\Laradoc;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Victoranw\Laradoc\Commands\AddUserCommand;
use Victoranw\Laradoc\Http\Traits\AuthTrait;

class LaradocServiceProvider extends ServiceProvider
{
    use AuthTrait;
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'victoranw');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laradoc');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Middleware
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('authDoc', \Victoranw\Laradoc\Middleware\AuthDoc::class);
        $router->pushMiddlewareToGroup('adminDoc', \Victoranw\Laradoc\Middleware\AdminDoc::class);

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
            $this->commands([
                AddUserCommand::class,
            ]);
        }

        // Connect user
        if (isset($_COOKIE['laradoc_user'])) {
            $user = $this->getUser();
            if ($user) {
                Auth::guard(config('laradoc.auth.guard'))->login($user);
            }
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laradoc.php', 'laradoc');

        // Register the service the package provides.
        $this->app->singleton('laradoc', function ($app) {
            return new Laradoc;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laradoc'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laradoc.php' => config_path('laradoc.php'),
        ], 'laradoc.config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'courier-migrations');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/victoranw'),
        ], 'laradoc.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/victoranw'),
        ], 'laradoc.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
