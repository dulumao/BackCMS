<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function getShow( $id )
    {
        $page = \App\Models\Page::find( $id );

        if ( $page->enabled == 0 ) abort( 404 );

        if ( $page->engine == 2 ) {
            return compileBlade( $page->body );
        } else {
            return $page->body;
        }
    }
}
