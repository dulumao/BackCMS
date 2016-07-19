<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use SoftDeletes;

    public function getArchiveField()
    {
        return $this->belongsTo( '\App\Models\ArchiveField', 'archive_field_id' );
    }

    public function getField()
    {
        return json_decode( $this->body );
    }

//    public function getBodyAttribute( $value )
//    {
//        return json_decode($value);
//    }
}
