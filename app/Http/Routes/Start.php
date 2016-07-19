<?php

\DB::enableQueryLog();
//Cache::flush();
if ( env( 'APP_ENV' ) === 'local' ) {
    Artisan::call( 'view:clear' );
}

Route::group( [
    'prefix'    => Config()->get( 'route.admin.prefix' ),
    'namespace' => Config()->get( 'route.admin.namespace' ),
], function () {
    require('Backend.php');
} );

Route::group( [
    'prefix'    => Config()->get( 'route.web.prefix' ),
    'namespace' => Config()->get( 'route.web.namespace' )
], function () {
    require('Frontend.php');
} );

/*
 * 301 跳转使用
 * */

//Route::get('/', function(){
//    return Redirect::to(Config()->get( 'route.web.prefix' ), 301);
//});
