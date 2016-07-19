<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermissionRole extends Model
{

    public function getAdminPermissionUser()
    {
        return $this->hasMany( '\App\Models\AdminPermissionUser', 'admin_permission_role_id' );
    }

}
