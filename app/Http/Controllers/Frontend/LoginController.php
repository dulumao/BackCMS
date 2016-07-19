<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\FrontendRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    public function getIndex()
    {
        return View( 'Frontend.User.Login' );
    }

    public function postIndex( FrontendRequest $request )
    {
        $username = $request->input( 'username' );
        $password = $request->input( 'password' );

        /*$login = \Auth::guard( 'admin' )*/

        $login = \Auth( 'web' )->attempt( [
            'username' => $username,
            'password' => $password,
        ] );

        if ( $login ) {

            $activity          = new \App\Models\Activity;
            $activity->guard   = 'web';
            $activity->content = '登录系统';
            $activity->userid  = Auth( 'web' )->user()->id;
            $activity->save();

            return Response()->json( [
                'code'    => 'success',
                'message' => '登录成功!',
                'auth'    => Auth( 'admin' )->user()
            ] );
        } else {
            return Response()->json( [
                'code'    => 'error',
                'message' => '登录失败!',
            ] );
        }
    }

    public function getRegister()
    {
        return View( 'Frontend.User.Register' );
    }

    public function postRegister( FrontendRequest $request )
    {
        $username = $request->input( 'username' );
        $password = $request->input( 'password' );
        $email    = $request->input( 'email' );
        $nickname = $request->input( 'nickname' );
        $phone    = $request->input( 'phone' );

        $this->validate( $request, [
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'email'    => 'required|unique:users|email',
            'phone'    => 'required',
        ], [
            'required' => '必填写内容',
            'unique'   => '信息已经存在了',
        ] );

        $user           = new \App\Models\User;
        $user->username = $username;
        $user->password = \Hash::make( $password );
        $user->email    = $email;
        $user->nickname = $nickname;
        $user->phone    = $phone;

        if ( $user->save() ) {
            Auth( 'web' )->login( $user, true );

            return Response()->json( [
                'code'    => 'success',
                'message' => '注册成功!'
            ] );
        } else {
            return Response()->json( [
                'code'    => 'error',
                'message' => '注册失败!',
            ] );
        }
    }

    public function getLogout()
    {

        $activity          = new \App\Models\Activity;
        $activity->guard   = 'web';
        $activity->content = '安全退出系统';
        $activity->userid  = Auth( 'web' )->user()->id;
        $activity->save();

        \Auth( 'web' )->logout();

        return Redirect()->action( 'Frontend\LoginController@getIndex' );
    }
}
