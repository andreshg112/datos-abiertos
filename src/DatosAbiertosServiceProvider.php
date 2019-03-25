<?php

namespace Andreshg112\DatosAbiertos;

use Illuminate\Support\ServiceProvider;
use Andreshg112\DatosAbiertos\Datasets\Colegios;
use Andreshg112\DatosAbiertos\Datasets\Divipola;
use Andreshg112\DatosAbiertos\Datasets\OrganismosTransito;

class DatosAbiertosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/datos-abiertos.php' => config_path('datos-abiertos.php'),
            ], 'datos-abiertos');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/datos-abiertos.php', 'datos-abiertos');

        // Register the main class to use with the facade
        $this->app->singleton('colegios', function () {
            return new Colegios;
        });

        $this->app->singleton('divipola', function () {
            return new Divipola;
        });

        $this->app->singleton('organismo-transito', function () {
            return new OrganismosTransito;
        });
    }
}
