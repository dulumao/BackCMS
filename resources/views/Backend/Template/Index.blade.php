
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>模版 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
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

        <div data-ng-controller="forms">

            <nav class="uk-navbar uk-margin-large-bottom">
                <span class="uk-hidden-small uk-navbar-brand">模版</span>
                <div class="uk-hidden-small uk-navbar-content">
                    <form class="uk-form uk-margin-remove uk-display-inline-block">
                        <div class="uk-form-icon">
                            <i class="uk-icon-filter"></i>
                            <input type="text" placeholder="搜索模版名字">
                        </div>
                    </form>
                </div>
                <ul class="uk-navbar-nav">
                    <li><a href="{{ Action('Backend\TemplateController@getCreate') }}" title="添加模版" data-uk-tooltip="{pos:'right'}"><i class="uk-icon-plus-circle"></i></a></li>
                </ul>
            </nav>

            <div class="app-panel">
                <table class="uk-table uk-table-striped" multiple-select="{model:forms}">
                    <thead>
                    <tr>
                        <th width="10"><input class="js-select-all" type="checkbox" @click="selectAll" v-model="allSelected"></th>
                        <th width="60%">模版名称</th>
                        <th width="20%">模版类型</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $templates as $template )
                    <tr class="js-multiple-select">
                        <td>
                            @if ( $template->system === 0 )
                                <input class="js-select" type="checkbox" v-model="ids" @click="select" value="{{ $template->id }}">
                            @endif
</td>
                        <td>
                            <a href="{{ Action('Backend\TemplateController@getEdit',$template->id) }}">{{ $template->name }}</a>
                        </td>
                        <td>
                            @if ( $template->type == 1 )
                                碎片模版
                            @else
                                文章模版
                            @endif
                        </td>
                        <td>
                            @if ( $template->system == 1 )
                                <div class="uk-badge">系统默认</div>
                            @endif
                        </td>
                        <td>
                            <div class="uk-link uk-float-right" data-uk-dropdown>
                                <i class="uk-icon-bars"></i>
                                <div class="uk-dropdown">
                                    <ul class="uk-nav uk-nav-dropdown uk-nav-parent-icon">
                                        <li><a href="{{ Action('Backend\TemplateController@getEdit',$template->id) }}"><i class="uk-icon-pencil"></i> 编辑模版</a></li>
                                        @if ( $template->system == 0 )
                                            <li class="uk-nav-divider"></li>
                                            <li class="uk-danger"><a href="#" @click="delete({{ $template->id }},$event)"><i class="uk-icon-minus-circle"></i> 删除模版</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="uk-margin-top" v-if="ids.length > 0">
                    <button class="uk-button uk-button-danger" @click="deleteAll()"><i class="uk-icon-trash-o"></i> 批量删除</button>
                </div>
            </div>

            {{--<div class="uk-text-center app-panel" data-ng-show="forms && !forms.length">
                <h2><i class="uk-icon-inbox"></i></h2>
                <p class="uk-text-large">您还没有创建任何模版.</p>

                <a href="//" class="uk-button uk-button-success uk-button-large">创建模版</a>
            </div>--}}

        </div>
    </div>
</div>

</body>
</html>
<script>
    $(function(){
        new Vue({
            el: '.app-main',
            data: {
                selected: [],
                allSelected: false,
                ids: [],
            },
            methods: {
                selectAll: function () {
                    var self = this;
                    self.ids = [];

                    if (!self.allSelected) {
                        $.each($('.js-select'), function (i, obj) {
                            self.ids.push($(obj).val());
                        });
                    }
                },
                select: function () {
                    this.allSelected = false;
                },
                delete: function (id, event) {
                    if (confirm('确定要删除嘛?')) {
                        Vue.http({
                            url: '{{ Action('Backend\TemplateController@postDelete') }}',
                            data: {
                                ids: id,
                                _token: '{{ csrf_token() }}'
                            },
                            method: 'post'
                        }).success(function (data) {
                            if (data.code == 'success') {
                                UIkit.notify({
                                    message: '删除成功!',
                                    status: 'success',
                                    timeout: 5000,
                                    pos: 'top-center'
                                });
                            } else {
                                UIkit.notify({
                                    message: '删除失败!',
                                    status: 'info',
                                    timeout: 5000,
                                    pos: 'top-center'
                                });
                            }
                        }).error(function () {
                            UIkit.notify({
                                message: '删除失败!',
                                status: 'info',
                                timeout: 5000,
                                pos: 'top-center'
                            });
                        });
                    }
                },
                deleteAll:function(){
                    if (confirm('确定删除嘛?')) {
                        this.$http({
                            url: '{{ Action('Backend\TemplateController@postDelete') }}',
                            data: {
                                ids: this.ids,
                                _token: '{{ csrf_token() }}'
                            },
                            'method': 'post'
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
                        }).error(function (data) {
                            UIkit.notify({
                                message: '删除失败!',
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
