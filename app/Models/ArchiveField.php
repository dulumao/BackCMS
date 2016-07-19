<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArchiveField extends Model
{
    use SoftDeletes;

//    public function getFieldAttribute( $value )
//    {
//        return json_decode($value);
//    }

    public function getArchive()
    {
        return $this->hasMany('\App\Models\Archive');
    }

    public function getListTemplate()
    {
        return $this->belongsTo( '\App\Models\Template', 'list_template' );
    }

    public function getShowTemplate()
    {
        return $this->belongsTo( '\App\Models\Template', 'show_template' );
    }
}
