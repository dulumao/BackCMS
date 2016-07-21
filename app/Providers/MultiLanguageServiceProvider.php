<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MultiLanguageServiceProvider extends ServiceProvider
{

    protected $defer = true;

    public function register()
    {
        $this->app->singleton( 'multi.language', function ( $app ) {

            $locale = \App\Models\Configure::whereKey('web_lang')->first()->value;

            $trans = new \App\Partner\Translator( languages(), app()->getLocale() );

            $trans->setFallback( $locale );

            return $trans;
        } );
    }


    public function provides()
    {
        return [ 'multi.language' ];
    }
}
