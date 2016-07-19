<?php

namespace App\Http\Middleware;

use Closure;

class Pjax
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle( $request, Closure $next )
    {
        $response = $next( $request );

        if ( !$response->isRedirection() && $request->pjax() ) {

            $htmDoc = new \DOMDocument;
            $htmDoc->loadHTML( $response->getContent() );
            $body              = $htmDoc->getElementById( $request->header( 'X-PJAX-CONTAINER' ) );
            $responseContainer = $htmDoc->saveHTML( $body[ 0 ] );
            $response->setContent( $responseContainer );

            /*
             * 使用第三方插件获取单独节点
             * */
            /*$responseContainer = $dom( $request->header('X-PJAX-CONTAINER') );
            $response->setContent( $responseContainer->html() );*/
            $response->header( 'X-PJAX-URL', $request->getRequestUri() );
        }

        return $response;
    }
}
