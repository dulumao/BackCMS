<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>权限组 - {{ $config['web_name'] }}</title>
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
        <style>
            .group-list li {
                position: relative;
                overflow: hidden;
            }

            .group-actions {
                position: absolute;
                display: none;
                min-width: 60px;
                text-align: right;
                top: 5px;
                right: 10px;
            }

            .group-actions li {
                margin: 0;
            }

            .group-actions, .group-actions a {
                font-size: 11px;
            }

            .group-list li:hover .group-actions a {
                color: #666;
            }

            .group-list li.uk-active .group-actions a {
                color: #fff;
            }

            .group-list li.uk-active .group-actions,
            .group-list li:hover .group-actions {
                display: block;
            }
        </style>

        <h1>
            <a href="{{ Action('Backend\SettingController@getIndex') }}">设置</a> / <a
                    href="{{ Action('Backend\SettingController@getAdmins') }}">管理员</a> / 组
        </h1>

        <div class="app-panel">
            <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
                <div class="uk-width-medium-1-4">
                    <ul class="uk-nav uk-nav-side group-list">
                        <li class="uk-nav-header"><i class="uk-icon-group"></i> 权限组</li>
                        @foreach($adminPermissionRoles as $adminPermissionRole)
                            <li>
                                <a>{{ $adminPermissionRole->name }}</a>
                                <ul class="uk-subnav group-actions uk-animation-slide-right">
                                    <li>
                                        <a href="{{ Action('Backend\SettingController@getAdminGroups',$adminPermissionRole->id) }}">
                                            @if ( $adminPermissionRole->name == '超级管理员' )
                                            <i class="uk-icon-eye"></i>
                                            @else
                                            <i class="uk-icon-pencil"></i>
                                            @endif
                                        </a>
                                    </li>
                                    @if ( $adminPermissionRole->name != '超级管理员' )
                                    <li>
                                        <a href="#" @click.prevent="delete({{ $adminPermissionRole->id }})"><i class="uk-icon-trash-o"></i></a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    <button class="uk-button uk-button-success" title="添加"
                            data-uk-tooltip="{pos:'bottom'}" @click="create"><i class="uk-icon-plus"></i></button>
                    @if ($role->name != '超级管理员' )
                    <button class="uk-button uk-button-primary" @click="save">保存</button>
                    @endif
                </div>
                <div class="uk-width-medium-3-4">

                    <div class="uk-margin-large-bottom">
                        <ul class="uk-tab" data-uk-tab="{connect:'#group-sections'}">
                            <li class="uk-active"><a>权限</a></li>
                            {{--<li><a>Settings</a></li>--}}
                        </ul>
                    </div>

                    <div id="group-sections" class="uk-switcher uk-margin">
                        <div>
                            @foreach( $adminPermissions as $component => $permissions )
                                <div class="uk-margin">
                                    <div class="uk-grid uk-grid-divider">
                                        <div class="uk-width-medium-1-3 uk-text-small">
                                            <strong><i class="uk-icon-cog"></i>
                                                @if ( $component == 'Archive' )
                                                    文章组件
                                                @elseif ( $component == 'Page' )
                                                    单页组件
                                                @elseif ( $component == 'Template' )
                                                    模版
                                                @elseif ( $component == 'Form' )
                                                    表单
                                                @elseif ( $component == 'Manager' )
                                                    文件组件
                                                @elseif ( $component == 'Setting' )
                                                    设置
                                                @endif
                                            </strong>
                                        </div>
                                        <div class="uk-width-medium-2-3">
                                            <table class="uk-table uk-table-hover uk-text-small">
                                                <tbody>
                                                @foreach( $permissions as $permission )
                                                    <tr>
                                                        <td class="{{ $role->name == '超级管理员' ? 'uk-text-muted' : null }}"
                                                            width="80%">{{ $permission['label'] }} {{ $permission['name'] }}</td>
                                                        <td align="right">
                                                            <input type="checkbox" v-model="ids" value="{{ $permission['id'] }}" {{ $permission['selected'] ? 'checked="checked"' : null }} {{ $role->name == '超级管理员' ? 'disabled="disabled" checked="checked"' : null }}>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{--<div class="uk-form">
                            <div class="uk-form-row">
                                <label>Media root path </label>
                                <input type="text" placeholder="/" class="uk-width-1-1" title="Relative to /" data-uk-tooltip>
                            </div>
                        </div>--}}
                    </div>
                </div>
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
            data: {
                ids: [],
            },
            methods: {
                delete:function(roleId){
                    this.$http({
                        url: '{{ Action('Backend\SettingController@postDeleteAdminGroups') }}',
                        data: {
                            roleId: roleId,
                            _token: '{{ csrf_token() }}'
                        },
                        method: 'post',
                    }).success(function (data) {
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
                    }).error(function () {
                        UIkit.notify({
                            message: '删除失败!',
                            status: 'info',
                            timeout: 2000,
                            pos: 'top-center'
                        });
                    });
                },
                save: function () {
                    this.$http({
                        url: '{{ Action('Backend\SettingController@postSaveAdminGroups',$role->id) }}',
                        data: {
                            ids: this.ids,
                            _token: '{{ csrf_token() }}'
                        },
                        method: 'post',
                    }).success(function (data) {
                        if (data.code == 'success') {
                            UIkit.notify({
                                message: '保存成功!',
                                status: 'success',
                                timeout: 2000,
                                pos: 'top-center'
                            });
                        } else {
                            UIkit.notify({
                                message: '保存失败!',
                                status: 'info',
                                timeout: 2000,
                                pos: 'top-center'
                            });
                        }
                    }).error(function () {
                        UIkit.notify({
                            message: '保存失败!',
                            status: 'info',
                            timeout: 2000,
                            pos: 'top-center'
                        });
                    });
                },
                create: function () {
                    var label = prompt('请输入组名字');
                    if (label) {
                        this.$http({
                            url: '{{ Action('Backend\SettingController@postCreateAdminGroups') }}',
                            data: {
                                label: label,
                                _token: '{{ csrf_token() }}'
                            },
                            method: 'post',
                        }).success(function (data) {
                            if (data.code == 'success') {
                                UIkit.notify({
                                    message: '创建成功!',
                                    status: 'success',
                                    timeout: 2000,
                                    pos: 'top-center'
                                });
                            } else {
                                UIkit.notify({
                                    message: '创建失败!',
                                    status: 'info',
                                    timeout: 2000,
                                    pos: 'top-center'
                                });
                            }
                        }).error(function () {
                            UIkit.notify({
                                message: '创建失败!',
                                status: 'info',
                                timeout: 2000,
                                pos: 'top-center'
                            });
                        });
                    }
                }
            }
        });
    });
</script>
