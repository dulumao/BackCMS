<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use SoftDeletes;

    // public $timestamps = false;

    // protected $fillable =  ['id', 'content', 'archive_id'];
    // protected $fillable =  ['content'];
//    protected $guarded = ['id'];
    protected $dates = [ 'deleted_at' ];

//    protected $touches = ['archives'];

    public function getAdminPermissionRole()
    {
        return $this->belongsTo( '\App\Models\AdminPermissionRole', 'admin_permission_role_id' );
    }

}
