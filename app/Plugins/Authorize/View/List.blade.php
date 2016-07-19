<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册会员 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>

    <script src="//cdn.bootcss.com/vue/1.0.24/vue.js"></script>
    <script src="//cdn.bootcss.com/vue-resource/0.7.2/vue-resource.min.js"></script>
</head>
<body>

@include('Backend.Common.Nav')

<div class="app-main">
    <div class="app-wrapper">

        <div>
            <nav class="uk-navbar uk-margin-large-bottom">
                <span class="uk-hidden-small uk-navbar-brand">表单组件</span>

                <div class="uk-hidden-small uk-navbar-content">
                    <form class="uk-form uk-margin-remove uk-display-inline-block">
                        <div class="uk-form-icon">
                            <i class="uk-icon-filter"></i>
                            <input type="text" placeholder="搜索表单名字">
                        </div>
                    </form>
                </div>
                <ul class="uk-navbar-nav">
                    <li><a href="{{ Action('Backend\FormController@getCreate') }}" title="添加表单"
                           data-uk-tooltip="{pos:'right'}"><i class="uk-icon-plus-circle"></i></a></li>
                </ul>
            </nav>

            <div class="app-panel">
                <table class="uk-table uk-table-striped" multiple-select="{model:forms}">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>登录账号</th>
                        <th>邮箱</th>
                        <th>电话</th>
                        <th>昵称</th>
                        <th>注册时间</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $users as $user )
                        <tr class="js-multiple-select">
                            <td>
                                {{ $user->id }}
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->nickname }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                <div class="uk-link uk-float-right" data-uk-dropdown>
                                    <i class="uk-icon-bars"></i>
                                    <div class="uk-dropdown">
                                        <ul class="uk-nav uk-nav-dropdown uk-nav-parent-icon">
                                            <li class="uk-danger"><a href="#" @click="delete({{ $user->id }},$event)"><i class="uk-icon-minus-circle"></i> 删除数据</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
</html>
