<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BootServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        if ( \Storage::has('installed') ) {
            $config = [ ];

            foreach ( \App\Models\Configure::all() as $configure ) {
                $config[ $configure->key ] = $configure->value;
            }

            view()->composer( '*', function ( $view ) use ( &$config ) {
                $view->with( 'config', $config );
            } );
        }
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
