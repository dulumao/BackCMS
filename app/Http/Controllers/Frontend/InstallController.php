<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InstallController extends Controller
{
    public function getIndex()
    {
        if ( \Storage::has( 'installed' ) ) {
            return View( 'Install.Message' )->with( [
                'message' => '已经安装过系统了'
            ] );
        } else {
            \Artisan::call( 'migrate:install' );
            \Artisan::call( 'migrate' );
            \Artisan::call( 'db:seed' );
            \Storage::put( 'installed', "BackCMS Init Success.\nUninstall Password:" . str_random( 32 ) );

            return View( 'Install.Index' );
        }
    }

    public function getUninstall()
    {
        $installed = \Storage::get( 'installed' );
        $password  = explode( ':', $installed )[ 1 ];

        if ( $password == Request()->segment( 3 ) ) {
            \Schema::dropIfExists( 'users' );
            \Schema::dropIfExists( 'password_resets' );
            \Schema::dropIfExists( 'activities' );
            \Schema::dropIfExists( 'admin_permission_roles' );
            \Schema::dropIfExists( 'admin_permission_users' );
            \Schema::dropIfExists( 'admin_permissions' );
            \Schema::dropIfExists( 'admins' );
            \Schema::dropIfExists( 'archive_fields' );
            \Schema::dropIfExists( 'archives' );
            \Schema::dropIfExists( 'configures' );
            \Schema::dropIfExists( 'forms' );
            \Schema::dropIfExists( 'pages' );
            \Schema::dropIfExists( 'templates' );
            \Schema::dropIfExists( 'migrations' );

            \Storage::delete( 'installed' );

            return View( 'Install.Message' )->with( [
                'message' => '卸载系统成功'
            ] );
        } else {
            abort( 403 );
        }

    }

}
