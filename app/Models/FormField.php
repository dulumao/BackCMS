<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use SoftDeletes;

    public function getPluginAttribute( $value )
    {
        $pluginArray = explode( '/', $value );

        return isset( $pluginArray[ 1 ] ) ? : $pluginArray[ 0 ];
    }
}
