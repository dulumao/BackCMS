<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PluginsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton( 'plugins', function ( $app ) {
            $blade = $app[ 'view' ]->getEngineResolver()->resolve( 'blade' )->getCompiler();

            return new \App\Plugins\Plugins( $app, $blade );
        } );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
