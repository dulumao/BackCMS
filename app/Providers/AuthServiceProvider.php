<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies
        = [
            'App\Model' => 'App\Policies\ModelPolicy',
        ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return void
     */
    public function boot( GateContract $gate )
    {
        $this->registerPolicies( $gate );

        if ( \Storage::has('installed') ) {
            $adminPermissions = \App\Models\AdminPermission::all();
            foreach ( $adminPermissions as $adminPermission ) {
                $gate->define( $adminPermission->name, function ( $admin ) use ( $adminPermission ) {
                    $adminPermissionRoute = $admin->getAdminPermissionRole;
                    $adminPermissionIds   = \App\Models\AdminPermissionUser::select( 'admin_permission_id' )->whereAdminPermissionRoleId( $adminPermissionRoute->id )->get()->toArray();
                    $adminPermissionIds   = array_flatten( $adminPermissionIds );
                    if ( in_array( $adminPermission->id, $adminPermissionIds ) || $adminPermissionRoute->name == '超级管理员' ) {
                        return true;
                    } else {
                        return false;
                    }
                } );
            }
        }

        /*

        $gate->define( 'admin-access', function ( $user ) {
            return $user->role == 'admin';
        } );

        $gate->define( 'manager-access', function ( $user ) {
            return $user->role == 'manager';
        } );

        $gate->define( 'customer-access', function ( $user ) {
            return $user->role == 'customer';
        } );

        dd( \Auth('admin')->can('admin-access') );

        */
    }
}
