<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BackendController;
use App\Http\Requests\BackendRequest;

class ManagerController extends BackendController
{
    public function getIndex()
    {
        $this->permission();

        return View( 'Backend.Manager.Index' );
    }

    public function postRoot( BackendRequest $request )
    {
        abort(403);
        $this->permission();

        $root     = $request->input( 'root' );
        $onlyType = $request->input( 'onlyType', 'all' );

        $files = [ ];

        $folderTotal = 0;
        $fileTotal   = 0;
        if ( !empty( $root ) ) $root = ltrim( $root, DIRECTORY_SEPARATOR );

        foreach ( glob( base_path( $root . DIRECTORY_SEPARATOR . '*' ) ) as $key => $file ) {
            $name      = ltrim( str_replace( dirname( $file ), null, $file ), DIRECTORY_SEPARATOR );
            $directory = str_replace( base_path(), null, dirname( $file ) . DIRECTORY_SEPARATOR );

            if ( is_dir( $file ) )
                $folderTotal++;
            else
                $fileTotal++;

            if ( is_dir( $file ) && ( $onlyType != 'file' ) ) {
                $files[ $key ][ 'type' ]         = 'folder';
                $files[ $key ][ 'fileSize' ]     = null;
                $files[ $key ][ 'modifiedTime' ] = null;
                $files[ $key ][ 'name' ]         = $name;
                $files[ $key ][ 'directory' ]    = $directory;
                $files[ $key ][ 'fileType' ]     = pathinfo( $file, PATHINFO_EXTENSION );
                $files[ $key ][ 'full' ]         = $file;
            } elseif ( !is_dir( $file ) && ( $onlyType != 'folder' ) ) {
                $files[ $key ][ 'type' ]         = 'file';
                $files[ $key ][ 'fileSize' ]     = round( filesize( $file ) / 1024, 2 ) . ' kb';
                $files[ $key ][ 'modifiedTime' ] = date( "Y-m-d H:i:s", fileatime( $file ) );
                $files[ $key ][ 'name' ]         = $name;
                $files[ $key ][ 'directory' ]    = $directory;
                $files[ $key ][ 'fileType' ]     = pathinfo( $file, PATHINFO_EXTENSION );
                $files[ $key ][ 'full' ]         = $file;
            }
        }

//        $files = array_sort( $files, function ( $value ) {
//            return $value[ 'type' ] == 'file';
//        } );

        if ( $files )
            return Response()->json( [
                'code'        => 'success',
                'folderTotal' => $folderTotal,
                'fileTotal'   => $fileTotal,
                'files'       => $files
            ] );
        else
            return Response()->json( [
                'code'        => 'error',
                'folderTotal' => $folderTotal,
                'fileTotal'   => $fileTotal,
            ] );
    }

    public function postCreateFolder( BackendRequest $request )
    {
        abort( 403 );
        $this->permission();

        $name = $request->input( 'name' );
        $root = $request->input( 'root' );

        $root = base_path( $root . DIRECTORY_SEPARATOR . ltrim( $name, DIRECTORY_SEPARATOR ) );

        if ( @mkdir( $root ) )
            return Response()->json( [
                'code' => 'success'
            ] );
        else
            return Response()->json( [
                'code' => 'error'
            ] );
    }

    public function postCreateFile( BackendRequest $request )
    {
        abort( 403 );
        $this->permission();

        $name = $request->input( 'name' );
        $root = $request->input( 'root' );

        $root = base_path( $root . DIRECTORY_SEPARATOR . ltrim( $name, DIRECTORY_SEPARATOR ) );

        if ( @touch( $root ) )
            return Response()->json( [
                'code' => 'success'
            ] );
        else
            return Response()->json( [
                'code' => 'error'
            ] );
    }

    public function postOpenFile( BackendRequest $request )
    {
        abort( 403 );
        $this->permission();

        $full     = $request->input( 'full' );
        $fileType = $request->input( 'fileType' );

        switch ( $fileType ) {
            case 'md':
            case 'txt':
            case 'xml':
            case 'json':
            case 'js':
            case 'html':
            case 'php':
                $raw = file_get_contents( $full );

                return Response()->json( [
                    'code'     => 'success',
                    'fileType' => $fileType,
                    'raw'      => View( 'Backend.Manager.Open' )->with( [
                        'raw'  => $raw,
                        'full' => $full
                    ] )->render()
                ] );
            default:
                return Response()->json( [
                    'code' => 'error'
                ] );
        }
    }

    public function postRenameFile( BackendRequest $request )
    {
        abort( 403 );
        $this->permission();

        $oldname = $request->input( 'oldname' );
        $name    = $request->input( 'name' );
        $root    = $request->input( 'root' );

        $root = base_path( $root . DIRECTORY_SEPARATOR );

        if ( @rename( $root . $oldname, $root . ltrim( $name, DIRECTORY_SEPARATOR ) ) )
            return Response()->json( [
                'code' => 'success'
            ] );
        else
            return Response()->json( [
                'code' => 'error'
            ] );
    }

    public function postDeleteFile( BackendRequest $request )
    {
        $this->permission();

        $names = $request->input( 'name' );
        $root  = $request->input( 'root' );

        if ( !is_array( $names ) ) {
            $root = base_path( $root . DIRECTORY_SEPARATOR . ltrim( $names, DIRECTORY_SEPARATOR ) );

            if ( @unlink( $root ) )
                return Response()->json( [
                    'code' => 'success'
                ] );
            else
                return Response()->json( [
                    'code' => 'error'
                ] );
        } else {
            $return  = [ ];
            $newRoot = null;
            foreach ( $names as $name ) {
                $newRoot  = base_path( $root . DIRECTORY_SEPARATOR . ltrim( $name, DIRECTORY_SEPARATOR ) );
                $return[] = @unlink( $newRoot );
            }

            if ( $return )
                return Response()->json( [
                    'code' => 'success'
                ] );
            else
                return Response()->json( [
                    'code' => 'error'
                ] );
        }
    }

    public function postFile( BackendRequest $request )
    {
        abort( 403 );
        $this->permission();

        if ( $request->hasFile( 'files' ) ) {
            $files         = $request->file( 'files' );
            $root          = $request->input( 'root' );
            $uploadSuccess = [ ];

            foreach ( $files as $file ) {
//                $extension       = $file->getClientOriginalExtension();
                /*$destinationPath = '/statics/uploads/' . time();
                $filename        = sprintf( '/%s.%s', str_random( 32 ), $extension );
                $uploadSuccess[] = $file->move( public_path() . $destinationPath, $filename );*/
                $uploadSuccess[] = $file->move( base_path( $root ), $file->getClientOriginalName() );
            }

            if ( $uploadSuccess )
                return Response()->json( [
                    'code' => 'success'
                ] );

        } else {
            return Response()->json( [
                'code' => 'error'
            ] );
        }
    }

    public function postAvatar( BackendRequest $request, $id = null )
    {
        $this->permission();

        $avatar = $request->file( 'avatar' );

        $this->validate( $request, [
            'avatar' => 'required|image',
        ], [
            'required' => '必填写内容',
            'memes'    => '类型错误'
        ] );

        if ( is_null( $id ) && !$id = $request->input( 'id' ) ) {
            return Response()->json( [
                'code'    => 'error',
                'message' => '先保存资料,再上传.'
            ] );
        }


        if ( $avatar->isValid() ) {
            $extension       = $avatar->getClientOriginalExtension();
            $destinationPath = '/statics/uploads/avatar/' . time();
            $filename        = sprintf( '/%s.%s', str_random( 32 ), $extension );
            $uploadSuccess   = $avatar->move( public_path() . $destinationPath, $filename );
            if ( $uploadSuccess ) {
                $user         = \App\Models\Admin::find( $id );
                $user->avatar = $destinationPath . $filename;
                $user->save();

                return Response()->json( [
                    'code'   => 'success',
                    'avatar' => $user->avatar
                ] );
            } else {
                return Response()->json( [
                    'code'    => 'error',
                    'message' => '仅支持jpeg,bmp,png,gif类型'
                ] );
            }
        }
    }

    public function postImage( BackendRequest $request )
    {
        $this->permission();

        $image = $request->file( 'image' );

        $this->validate( $request, [
            'image' => 'required|image',
        ], [
            'required' => '必填写内容',
            'memes'    => '类型错误'
        ] );

        if ( $image->isValid() ) {
            $extension       = $image->getClientOriginalExtension();
            $destinationPath = '/statics/uploads/images/' . time();
            $filename        = sprintf( '/%s.%s', str_random( 32 ), $extension );
            $uploadSuccess   = $image->move( public_path() . $destinationPath, $filename );
            if ( $uploadSuccess ) {

                return Response()->json( [
                    'code'  => 'success',
                    'image' => $destinationPath . $filename
                ] );
            } else {
                return Response()->json( [
                    'code'    => 'error',
                    'message' => '仅支持jpeg,bmp,png,gif类型'
                ] );
            }
        }
    }
}
