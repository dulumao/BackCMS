<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use SoftDeletes;
    //

    public function getField()
    {
        return json_decode( $this->body );
    }

}
