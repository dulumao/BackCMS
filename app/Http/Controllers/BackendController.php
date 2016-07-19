<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class BackendController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    private $controllerName;
    private $actionName;

    public function __construct()
    {
        $this->middleware( 'auth:admin' );

        list( $controller, $method ) = explode( '@', \Route::getCurrentRoute()->getActionName() );
        $this->controllerName = class_basename( $controller );
        $this->actionName     = $method;
    }

    public function permission( $name = null )
    {
        if ( is_null( $name ) ) {
            $action     = str_replace( strtolower( Request()->method() ), null, $this->actionName );
            $action     = preg_split( "/(?=[A-Z])/", $action );
            $controller = str_replace( 'Controller', null, $this->controllerName );
            $name       = $controller . implode( '.', $action );
        }

        if ( !Auth( 'admin' )->user()->can( $name ) ) Abort( 403 );
    }


}
