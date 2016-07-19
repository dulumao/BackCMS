<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use SoftDeletes;

    public function getUser( )
    {
        return $this->belongsTo('\App\Models\Admin','admin_id')->withTrashed();
    }
}
