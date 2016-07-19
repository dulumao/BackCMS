<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FormController extends Controller
{

    public function anyPlugin( $name )
    {
        $name = ucfirst( $name );

        \Plugins::register( $name, '\\App\\Plugins\\' . $name . '\\' . $name );

        return \Plugins::call( $name, [ $name ] );
    }

}
