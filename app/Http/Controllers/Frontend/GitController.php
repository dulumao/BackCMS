<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GitController extends Controller
{
    public function anyHookPush( $password )
    {
        if ( $password == 'allowgitpush' ) {
            $target = base_path('/gitUpdate.sh');
            $result = [ ];

            exec( "sh $target", $result, $ret );

            foreach( $result as $row ) {
                echo $row . "<br>";
            }
        } else {
            abort( 404 );
        }
    }
}
