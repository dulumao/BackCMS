<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理员编辑 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>
    <script src="{{ asset('assets/vendor/uikit/js/components/upload.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/uikit/js/components/form-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/uikit/js/components/form-password.js') }}" type="text/javascript"></script>
    <script src="//cdn.bootcss.com/vue/1.0.24/vue.js"></script>
    <script src="//cdn.bootcss.com/vue-resource/0.7.2/vue-resource.min.js"></script>
</head>
<body>

@include('Backend.Common.Nav')

<div class="app-main">
    <div class="app-wrapper">
        <script src="/assets/vendor/uikit/js/components/form-password.min.js" type="text/javascript"></script>
        <h1>
            <a href="{{ Action('Backend\SettingController@getIndex') }}">设置</a> / <a
                    href="{{ Action('Backend\SettingController@getAdmins') }}">管理员</a> / 编辑管理员</h1>

        <form class="uk-form" @submit.prevent="save">
            <div class="uk-grid" data-uk-margin>
                <div class="uk-width-medium-2-4">
                    <div class="app-panel">
                        <div class="uk-panel app-panel-box docked uk-text-center">
                            <div class="uk-thumbnail uk-rounded uk-form-file">
                                <img :src="src" style="height: 100px;width: 100px">
                                <input id="js-upload-select" type="file">
                                {{--<span class="uk-button uk-form-file" data-uk-tooltip title="上传文件">
                                <input id="js-upload-select" type="file" multiple="true" root="/">
                                <i class="uk-icon-plus"></i>--}}
                                </span>
                            </div>
                            <h2 class="uk-text-truncate">头像</h2>
                        </div>

                        <div class="uk-grid" data-uk-margin>
                            <div class="uk-width-medium-1-1">
                                {{ csrf_field() }}
                                <div class="uk-form-row">
                                    <label class="uk-text-small">昵称</label>
                                    <input class="uk-width-1-1 uk-form-large" type="text" name="nickname"
                                           value="{{ $admin->nickname }}">
                                </div>

                                <div class="uk-form-row">
                                    <label class="uk-text-small">账号名称</label>
                                    <input class="uk-width-1-1 uk-form-large" type="text" name="username"
                                           value="{{ $admin->username }}">
                                </div>

                                <div class="uk-form-row">
                                    <label class="uk-text-small">邮箱</label>
                                    <input class="uk-width-1-1 uk-form-large" type="text" name="email"
                                           value="{{ $admin->email }}">
                                </div>

                                <hr>

                                <div class="uk-form-row">
                                    <label class="uk-text-small">账号密码</label>

                                    <div class="uk-form-password uk-width-1-1">
                                        <input class="uk-form-large uk-width-1-1" type="password" name="password">
                                        <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'显示', lblHide:'隐藏'}">显示</a>
                                    </div>
                                    <div class="uk-alert">如果密码为空,则使用当前密码</div>
                                </div>

                                <div class="uk-form-row">
                                    <button class="uk-button uk-button-large uk-button-primary uk-width-1-2">保存</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="uk-width-medium-1-4 uk-form">
                    <h3>其他</h3>
                    <div class="uk-form-row">
                        <label class="uk-text-small">权限组</label>
                        <div class="uk-form-controls uk-margin-small-top">
                            <div class="uk-form-select" data-uk-form-select="{target:'a'}">
                                <i class="uk-icon-sitemap uk-margin-small-right"></i>
                                <a>{{ $admin->getAdminPermissionRole->name }}</a>
                                <select class="uk-width-1-1 uk-form-large" name="admin_permission_role_id">
                                    @foreach($adminPermissionRoles as $adminPermissionRole)
                                        <option value="{{ $adminPermissionRole->id }}" {{ $adminPermissionRole->id == $admin->admin_permission_role_id ? 'selected' : null }}>{{ $adminPermissionRole->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<script>
    $(function () {
        new Vue({
            el: '.app-main',
            data: {
                src: '{{ $admin->avatar }}'
            },
            ready: function () {
                var self = this;

                select = UIkit.uploadSelect($("#js-upload-select"), {
                    action: '{{ Action('Backend\ManagerController@postAvatar',$admin->id) }}',
                    type: 'json',
                    single: false,
                    param: 'avatar',
                    filelimit: 1,
                    params: {
                        _token: '{{ csrf_token() }}',
                    },
                    complete: function (data) {
                        if (data.code == 'success') {
                            self.src = data.avatar;

                            UIkit.notify({
                                message: '上传成功!',
                                status: 'success',
                                timeout: 2000,
                                pos: 'top-center'
                            });
                        } else {
                            UIkit.notify({
                                message: '上传失败!',
                                status: 'info',
                                timeout: 2000,
                                pos: 'top-center'
                            });
                        }
                    }
                });
            },
            methods: {
                save: function () {
                    this.$http({
                                data: $('.uk-form').serialize(),
                                method: 'post',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                }
                            })
                            .success(function (data) {
                                if (data.code == 'success') {
                                    UIkit.notify({
                                        message: '保存成功!',
                                        status: 'success',
                                        timeout: 2000,
                                        pos: 'top-center'
                                    });
                                } else {
                                    UIkit.notify({
                                        message: '保存失败',
                                        status: 'info',
                                        timeout: 2000,
                                        pos: 'top-center'
                                    });
                                }
                            })
                            .error(function () {
                                UIkit.notify({
                                    message: '保存失败!',
                                    status: 'info',
                                    timeout: 2000,
                                    pos: 'top-center'
                                });
                            });
                }
            }
        });
    });
</script>


