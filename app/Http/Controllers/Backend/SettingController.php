<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Requests\BackendRequest;

class SettingController extends BackendController
{
    public function getIndex()
    {
        $this->permission();

        return View( 'Backend.Setting.Index' );
    }

    public function getGeneral()
    {
        $this->permission();

        $configures = \App\Models\Configure::all();

        return View( 'Backend.Setting.General.Index' )->with( [
            'configures' => $configures
        ] );
    }

    public function postGeneral( BackendRequest $request )
    {
        $this->permission();

        $inputs  = $request->except( [ '_token' ] );
        $returns = [ ];

        foreach ( $inputs as $key => $value ) {
            $configure        = \App\Models\Configure::whereKey( $key )->first();
            $configure->value = $value;
            $returns          = $configure->save();
        }

        if ( $returns )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }

    public function getCreateGreneral()
    {
        $this->permission();

        return View( 'Backend.Setting.General.Create' );
    }

    public function postCreateGreneral( BackendRequest $request )
    {
        $this->permission();

        $name  = $request->input( 'name' );
        $key   = $request->input( 'key' );
        $value = $request->input( 'value' );

        $configure        = new \App\Models\Configure;
        $configure->name  = $name;
        $configure->key   = $key;
        $configure->value = $value;
        $configure->type  = 0;

        if ( $configure->save() )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );

    }

    public function postDeleteGreneral( BackendRequest $request )
    {
        $this->permission();

        $id = $request->input( 'id' );

        $configure = \App\Models\Configure::find( $id );

        if ( $configure->delete() )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }

    public function getAdmins()
    {
        $this->permission();

        $admins = \App\Models\Admin::all();

        return View( 'Backend.Setting.Admins.Index' )->with( [
            'admins' => $admins,
        ] );
    }

    public function getCreateAdmin()
    {
        $this->permission();

        $adminPermissionRoles = \App\Models\AdminPermissionRole::all();

        return View( 'Backend.Setting.Admins.Create' )->with( [
            'adminPermissionRoles' => $adminPermissionRoles
        ] );
    }

    public function postCreateAdmin( BackendRequest $request )
    {
        $this->permission();

        $username              = $request->input( 'username' );
        $nickname              = $request->input( 'nickname' );
        $email                 = $request->input( 'email' );
        $password              = $request->input( 'password' );
        $adminPermissionRoleId = $request->input( 'admin_permission_role_id' );

        $this->validate( $request, [
            'username'                 => 'required',
            'email'                    => 'required|email',
            'password'                 => 'required:min:6',
            'admin_permission_role_id' => 'required',
        ], [
            'required' => '必填写内容',
            'email'    => '邮箱格式错误',
        ] );

        $admin = new \App\Models\Admin;

        $admin->username                 = $username;
        $admin->nickname                 = $nickname;
        $admin->email                    = $email;
        $admin->password                 = \Hash::make( $password );
        $admin->admin_permission_role_id = $adminPermissionRoleId;

        if ( $admin->save() )
            return Response()->json( [
                'code' => 'success',
                'id'   => $admin->id
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }

    public function getAdminEdit( $id )
    {
        $this->permission();

        $admin                = \App\Models\Admin::find( $id );
        $adminPermissionRoles = \App\Models\AdminPermissionRole::all();

        return View( 'Backend.Setting.Admins.Edit' )->with( [
            'admin'                => $admin,
            'adminPermissionRoles' => $adminPermissionRoles
        ] );
    }


    public function postAdminEdit( BackendRequest $request, $id )
    {
        $this->permission();

        $username              = $request->input( 'username' );
        $nickname              = $request->input( 'nickname' );
        $email                 = $request->input( 'email' );
        $password              = $request->input( 'password' );
        $adminPermissionRoleId = $request->input( 'admin_permission_role_id' );

        $this->validate( $request, [
            'username'                 => 'required',
            'email'                    => 'required|email',
            'admin_permission_role_id' => 'required',
        ], [
            'required' => '必填写内容',
            'email'    => '邮箱格式错误',
        ] );

        $admin = \App\Models\Admin::find( $id );

        $admin->username                 = $username;
        $admin->nickname                 = $nickname;
        $admin->email                    = $email;
        $admin->admin_permission_role_id = $adminPermissionRoleId;

        if ( !empty( $password ) )
            $admin->password = \Hash::make( $password );

        if ( $admin->save() )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }

    public function getAdminGroups( $roleId = null )
    {
        $this->permission();

        $adminPermissionRoles = \App\Models\AdminPermissionRole::all();
        $adminPermissions     = [ ];
        $role                 = null;

        if ( !is_null( $roleId ) ) {
            $role = \App\Models\AdminPermissionRole::whereId( $roleId )->first();
        } else {
            $role = \App\Models\AdminPermissionRole::whereName( '超级管理员' )->first();
        }
        $adminPermissionIds = \App\Models\AdminPermissionUser::select( 'admin_permission_id' )->whereAdminPermissionRoleId( $role->id )->get()->toArray();
        $adminPermissionIds = array_flatten( $adminPermissionIds );

        foreach ( \App\Models\AdminPermission::all() as $key => $adminPermission ) {
            list( $adminPermissionComponent, $adminPermissionName ) = explode( '.', $adminPermission->name );
            $adminPermissions[ $adminPermissionComponent ][ $key ] = [
                'id'       => $adminPermission->id,
                'name'     => $adminPermission->name,
                'label'    => $adminPermission->label,
                'selected' => in_array( $adminPermission->id, $adminPermissionIds ) ? true : false
            ];
        }

        return View( 'Backend.Setting.Admins.Groups' )->with( [
            'adminPermissionRoles' => $adminPermissionRoles,
            'adminPermissions'     => $adminPermissions,
            'role'                 => $role
        ] );
    }

    public function postCreateAdminGroups( BackendRequest $request )
    {
        $this->permission();

        $label = $request->input( 'label' );

        if ( $label ) {
            $adminPermissionRole       = new \App\Models\AdminPermissionRole;
            $adminPermissionRole->name = $label;

            if ( $adminPermissionRole->save() )
                return Response()->json( [
                    'code' => 'success',
                ] );
            else
                return Response()->json( [
                    'code' => 'error',
                ] );
        } else {
            return Response()->json( [
                'code' => 'error',
            ] );
        }
    }

    public function postSaveAdminGroups( BackendRequest $request, $roleId )
    {
        $this->permission();

        $ids = $request->input( 'ids' );

        \App\Models\AdminPermissionUser::whereAdminPermissionRoleId( $roleId )->delete();

        foreach ( $ids as $id ) {
            $adminPermissionUser = new \App\Models\AdminPermissionUser;

            $adminPermissionUser->admin_permission_id      = $id;
            $adminPermissionUser->admin_permission_role_id = $roleId;
            $adminPermissionUser->save();
        }

        return Response()->json( [
            'code' => 'success',
        ] );
    }

    public function postDeleteAdminGroups( BackendRequest $request )
    {
        $this->permission();

        $roleId = $request->input( 'roleId' );

        $adminPermissionRole = \App\Models\AdminPermissionRole::find( $roleId );
        $adminPermissionRole->getAdminPermissionUser()->delete();

        if ( $adminPermissionRole->delete() )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }

    public function postDeleteAdmin( BackendRequest $request )
    {
        $this->permission();

        $id = $request->input( 'id' );

        $admin = \App\Models\Admin::find( $id );

        if ( $admin->username != 'admin' ) {
            if ( $admin->delete() )
                return Response()->json( [
                    'code' => 'success',
                ] );
            else
                return Response()->json( [
                    'code' => 'error',
                ] );
        } else {
            return Response()->json( [
                'code' => 'error',
            ] );
        }
    }

    public function getDatabase()
    {
        $this->permission();

        return View( 'Backend.Setting.Database.Index' );
    }

    public function getBackups()
    {
        $this->permission();

        $backupsPath = storage_path() . '/framework/backups';

        $files = [ ];

        foreach ( glob( storage_path() . '/framework/backups/*' ) as $key => $file ) {
            $name = ltrim( str_replace( dirname( $file ), null, $file ), DIRECTORY_SEPARATOR );

            $files[ $key ][ 'name' ]         = $name;
            $files[ $key ][ 'fileSize' ]     = round( filesize( $file ) / 1024, 2 ) . ' kb';
            $files[ $key ][ 'modifiedTime' ] = date( "Y-m-d H:i:s", fileatime( $file ) );
        }

        return View( 'Backend.Setting.Database.Backups.Index' )->with( [
            'backupsPath' => str_replace( base_path(), null, $backupsPath ),
            'files'       => $files
        ] );
    }

    public function postBackups()
    {
        $this->permission();

        \Plugins::register( 'backup', 'App\Plugins\Backup\Backup' );

        $backupsPath = storage_path() . '/framework/backups/';
        $filename    = uniqid() . '.sql';
        $return      = \Plugins::call( 'backup', [ $backupsPath . $filename ] );

        if ( $return )
            return Response()->json( [
                'code' => 'success',
            ] );
        else
            return Response()->json( [
                'code' => 'error',
            ] );
    }

    public function getUpdate()
    {
        $this->permission();

        return View( 'Backend.Setting.Update.Index' );
    }

    public function getInfo()
    {
        $this->permission();

        \Plugins::register( 'cache', 'App\Plugins\Cache\Cache' );

        $totalViewSize    = \Plugins::call( 'cache' )->getViewSize();
        $totalCacheSize   = \Plugins::call( 'cache' )->getCacheSize();
        $totalSessionSize = \Plugins::call( 'cache' )->getSessionSize();

        $testFiles        = [ 'cache', 'sessions', 'views' ];
        $testFilesResults = [ ];

        foreach ( $testFiles as $file ) {
            $file               = storage_path() . '/framework/' . $file;
            $isWritable         = \Plugins::call( 'cache' )->isWritable( $file );
            $testFilesResults[] = [
                'file'       => str_replace( base_path(), null, $file ),
                'isWritable' => $isWritable
            ];
        }

        return View( 'Backend.Setting.Info.Index' )->with( [
            'totalViewSize'    => $totalViewSize,
            'totalCacheSize'   => $totalCacheSize,
            'totalSessionSize' => $totalSessionSize,
            'testFilesResults' => $testFilesResults
        ] );
    }

    public function getAddons()
    {
        $this->permission();

        return View( 'Backend.Setting.Addons.Index' );
    }
}
