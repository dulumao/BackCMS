<?php

$languages = Request()->getLanguages();

if ( Request()->segment( 1 ) != 'localization' ) {
    if ( is_array( $languages ) ) {
        $language = str_replace( '_', '-', strtolower( $languages[ 0 ] ) );

        $cookieLanguage = Request()->cookie( 'language', null );

        if ( $cookieLanguage && in_array( $cookieLanguage, array_keys( languages() ) ) ) {
            app()->setLocale( $cookieLanguage );
        } else {
            app()->setLocale( \App\Models\Configure::whereKey('web_lang')->first()->value );
            Cookie()->queue( Cookie()->forever( 'language', $language ) );
        }
    }

}