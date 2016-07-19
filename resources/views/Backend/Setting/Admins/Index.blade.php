<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理员 - {{ $config['web_name'] }}</title>
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
                <span class="uk-navbar-brand"><a href="{{ Action('Backend\SettingController@getIndex') }}">设置</a> / 管理员</span>

                <div class="uk-navbar-content">
                    <form class="uk-form uk-margin-remove uk-display-inline-block">
                        <div class="uk-form-icon">
                            <i class="uk-icon-filter"></i>
                            <input type="text" placeholder="搜索管理员" data-ng-model="filter">
                        </div>
                    </form>
                </div>
                <ul class="uk-navbar-nav">
                    <li><a href="{{ Action('Backend\SettingController@getCreateAdmin') }}" title="创建管理员"
                           data-uk-tooltip="{pos:'right'}"><i class="uk-icon-plus-circle"></i></a></li>
                    <li><a href="{{ Action('Backend\SettingController@getAdminGroups') }}"
                           title="Manage account groups and permissions" data-uk-tooltip="{pos:'right'}"><i
                                    class="uk-icon-group"></i></a></li>
                </ul>
            </nav>

            <div class="uk-grid" data-uk-grid-margin data-uk-grid-match>
                @foreach( $admins as $admin )
                    <div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
                        <div class="app-panel app-panel-box uk-text-center">
                            <div class="uk-margin">
                                <img class="uk-rounded" src="{{ $admin->avatar }}" style="width: 60px;height: 60px"
                                     alt="gravatar">
                            </div>
                            <strong>{{ $admin->nickname }}</strong>

                            <div class="uk-margin">
                                <span class="uk-button-group">
                                    <a class="uk-button uk-button-small"
                                       href="{{ Action('Backend\SettingController@getAdminEdit',$admin->id) }}"
                                       title="编辑管理员"
                                       data-uk-tooltip="{pos:'bottom'}"><i class="uk-icon-pencil"></i></a>
                                    <a class="uk-button uk-button-danger uk-button-small" href="#" title="删除管理员"
                                       data-uk-tooltip="{pos:'bottom'}" @click.prevent="delete({{ $admin->id }})"><i
                                                class="uk-icon-minus-circle"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function () {
        new Vue({
            el: '.app-main',
            methods: {
                delete: function (id) {
                    this.$http({
                                url: '{{ Action('Backend\SettingController@postDeleteAdmin') }}',
                                data: {
                                    id: id,
                                    _token: '{{ csrf_token() }}',
                                },
                                method: 'post'
                            })
                            .success(function (data) {
                                if (data.code == 'success') {
                                    UIkit.notify({
                                        message: '删除成功!',
                                        status: 'success',
                                        timeout: 2000,
                                        pos: 'top-center'
                                    });
                                } else {
                                    UIkit.notify({
                                        message: '删除失败!',
                                        status: 'info',
                                        timeout: 2000,
                                        pos: 'top-center'
                                    });
                                }
                            })
                            .error(function () {
                                UIkit.notify({
                                    message: '删除失败!',
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
