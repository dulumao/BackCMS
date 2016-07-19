<?php
namespace App\Plugins\Test;

use Illuminate\Http\Request;

class Test
{
    public function run( $name )
    {
        $form         = new \App\Form;
        $form->body   = json_encode( Request()->except( '_token' ) );
        $form->plugin = $name;
        $form->save();

        return Redirect()->back();
    }
}