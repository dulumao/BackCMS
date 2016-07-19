<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\BackendRequest;
use App\Http\Controllers\BackendController;
use Illuminate\Support\Facades\Redirect;

class LoginController extends BackendController
{

//    protected $redirectTo = '/admin/dashboard';
//    protected $guard      = 'admin';


    public function __construct()
    {
        $this->middleware( 'auth:admin', [
            'except' => [
                'getIndex',
                'postCheck'
            ]
        ] );
    }

    public function getIndex()
    {
        if ( !Auth( 'admin' )->guest() )
            return Redirect()->action( 'Backend\DashboardController@getIndex' );

        return View( 'Backend.Login' );
    }

    public function postCheck( BackendRequest $request )
    {
        $username = $request->input( 'username' );
        $password = $request->input( 'password' );

        /*$login = \Auth::guard( 'admin' )*/

        $login = \Auth( 'admin' )->attempt( [
            'username' => $username,
            'password' => $password,
        ] );

        if ( $login ) {

            $activity           = new \App\Models\Activity;
            $activity->guard    = 'admin';
            $activity->content  = '登录系统';
            $activity->admin_id = Auth( 'admin' )->user()->id;
            $activity->save();

            return Response()->json( [
                'code'     => 'success',
                'message'  => '登录成功!',
                'auth'     => Auth( 'admin' )->user(),
                'redirect' => Action( 'Backend\DashboardController@getIndex' )
            ] );
        } else {
            return Response()->json( [
                'code'    => 'error',
                'message' => '登录失败!',
            ] );
        }
    }

    public function getLogout()
    {

        $activity           = new \App\Models\Activity;
        $activity->guard    = 'admin';
        $activity->content  = '安全退出系统';
        $activity->admin_id = Auth( 'admin' )->user()->id;
        $activity->save();

        \Auth( 'admin' )->logout();

        return Redirect()->action( 'Backend\LoginController@getIndex' );
    }
}
