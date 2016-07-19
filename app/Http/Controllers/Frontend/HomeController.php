<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function getIndex()
    {

        if ( !\Storage::has( 'installed' ) ) {
            return Redirect()->action( 'Frontend\InstallController@getIndex' );
        }

        $template       = \App\Models\Template::whereName( '首页' )->first();

        if ( $template->type == 2 ) {
            return compileBlade($template->code);
        } else {
            return $template->code;
        }
    }

}
