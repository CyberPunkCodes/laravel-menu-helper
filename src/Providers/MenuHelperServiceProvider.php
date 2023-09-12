<?php

namespace CyberPunkCodes\MenuHelper\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use CyberPunkCodes\MenuHelper\Console\Commands\MakeMenu;

class MenuHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/menu-helper.php', 'menu-helper');
        $this->mergeConfigFrom(__DIR__ . '/../../config/menu-helper-secondary.php', 'menu-helper-secondary');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ( config('menu-helper.demoMode', false) === true ) {
            $this->loadRoutesFrom(__DIR__.'/../../routes/demo-routes.php');
        }

        Blade::componentNamespace('CyberPunkCodes\\MenuHelper\\View\\Components', 'menuhelper');

        $this->loadViewsFrom(__DIR__ . '/../../views', 'menuhelper');

        if ($this->app->runningInConsole()) {

            $this->commands([
                MakeMenu::class,
            ]);

            $this->publishes([
                __DIR__ . '/../../stubs/config/menu-helper.php' => config_path('menu-helper.php'),
                __DIR__ . '/../../stubs/config/menu-helper-secondary.php' => config_path('menu-helper-secondary.php'),
            ], 'menuhelper-config');

        }
    }
}
