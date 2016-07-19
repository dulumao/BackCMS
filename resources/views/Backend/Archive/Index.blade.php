<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文章组件 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>


    {{--<script src="/assets/vendor/uikit/js/components/sortable.min.js?ver=0.13.0" type="text/javascript"></script>    <script src="/modules/core/Collections/assets/collections.js?ver=0.13.0" type="text/javascript"></script>
    <script src="/modules/core/Collections/assets/js/index.js?ver=0.13.0" type="text/javascript"></script>--}}
    <script src="//cdn.bootcss.com/vue/1.0.24/vue.js"></script>
    <script src="//cdn.bootcss.com/vue-resource/0.7.2/vue-resource.min.js"></script>
    <style>

        #groups-list li {
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

        .group-actions a {
            font-size: 11px;
        }

        #groups-list li.uk-active .group-actions,
        #groups-list li:hover .group-actions {
            display: block;
        }

        #groups-list li:hover .group-actions a {
            color: #666;
        }

        #groups-list li.uk-active a,
        #groups-list li.uk-active .group-actions a {
            color: #fff;
        }


    </style>

</head>
<body>

@include('Backend.Common.Nav')

<div class="app-main">
    <div class="app-wrapper">

        <div>
            <nav class="uk-navbar uk-margin-large-bottom">
                <span class="uk-hidden-small uk-navbar-brand">文章组件</span>

                <div class="uk-hidden-small uk-navbar-content">
                    <form class="uk-form uk-margin-remove uk-display-inline-block">
                        <div class="uk-form-icon">
                            <i class="uk-icon-filter"></i>
                            <input type="text" placeholder="搜索文章">
                        </div>
                    </form>
                </div>
                <ul class="uk-navbar-nav">
                    <li>
                        <a href="{{ Action('Backend\ArchiveController@getCreate') }}" title="添加文章组件"
                           data-uk-tooltip="{pos:'right'}">
                            <i class="uk-icon-plus-circle"></i>
                        </a>
                    </li>
                </ul>
                {{--<div class="uk-navbar-flip">
                    <div class="uk-navbar-content">
                        <div class="uk-button-group">
                            <button class="uk-button uk-button-primary" title="" data-uk-tooltip="{pos:'bottom'}"><i class="uk-icon-th"></i></button>
                            <button class="uk-button" title="Table mode" data-uk-tooltip="{pos:'bottom'}"><i class="uk-icon-th-list"></i></button>
                        </div>
                    </div>
                </div>--}}
            </nav>

            <div class="uk-grid uk-grid-divider" data-uk-grid-match data-uk-grid-margin>

                <div class="uk-width-medium-1-4">
                    <div class="uk-panel">
                        <ul class="uk-nav uk-nav-side uk-nav-plain">
                            <li class="uk-nav-header">分类名称</li>
                            <li><a>所有分类</a></li>
                        </ul>

                        <ul id="groups-list" class="uk-nav uk-nav-side uk-animation-fade uk-sortable" data-uk-sortable>
                            @foreach( $archiveFields as $field )
                                <li draggable="true">
                                    <a><i class="uk-icon-bars" style="cursor:move;"></i> {{ $field->name }}</a>
                                    <ul class="uk-subnav group-actions uk-animation-slide-right">
                                        <li><a href="{{ Action('Backend\ArchiveController@getList',$field->id) }}"><i
                                                        class="uk-icon-ellipsis-h"></i></a></li>
                                        <li><a href="{{ Action('Frontend\ArchiveController@getList',$field->id) }}"><i
                                                        class="uk-icon-eye"></i></a></li>
                                        <li><a href="#" @click="deleteField({{ $field->id }},$event)"><i
                                                    class="uk-icon-trash-o"></i></a></li>
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="uk-width-medium-3-4">
                    {{--<div class="uk-width-medium-3-4">--}}

                    <div class="uk-margin-bottom">
                        <span class="uk-badge app-badge">所有文章</span>
                    </div>

                    {{--<div class="uk-grid uk-grid-small" data-uk-grid-match>
                        <div class="uk-width-1-1 uk-width-medium-1-3 uk-grid-margin">

                            <div class="app-panel">

                                <a class="uk-link-muted" href="/collections/entries/aaa"><strong>ssss</strong></a>

                                <div class="uk-margin">
                                    <span class="uk-badge app-badge">sss Entries</span>
                                </div>

                                <div class="app-panel-box docked-bottom">

                                    <div class="uk-link" data-uk-dropdown="{mode:'click'}">
                                        <i class="uk-icon-bars"></i>
                                        <div class="uk-dropdown">
                                            <ul class="uk-nav uk-nav-dropdown uk-nav-parent-icon">

                                                <li><a href="/collections/entries/"><i class="uk-icon-list"></i> Show entries</a></li>
                                                <li><a href="/collections/entry/"><i class="uk-icon-plus-circle"></i> Create new entry</a></li>
                                                <li class="uk-nav-divider"></li>
                                                <li><a href="/collections/collection/"><i class="uk-icon-pencil"></i> Edit collection</a></li>
                                                <li><a><i class="uk-icon-copy"></i> Duplicate collection</a></li>
                                                <li class="uk-nav-divider"></li>
                                                <li class="uk-danger"><a href="#"><i class="uk-icon-minus-circle"></i> Delete collection</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>--}}

                    <div class="app-panel">
                        <table class="uk-table uk-table-striped">
                            <thead>
                            <tr>
                                <th width="10"><input class="js-select-all" type="checkbox" @click="selectAll" v-model="allSelected"></th>
                                <th width="50%">标题</th>
                                <th width="20%">创建时间</th>
                                <th width="20%">修改时间</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $archives as $archive )
                                <tr class="js-multiple-select">
                                    <td><input class="js-select" type="checkbox" v-model="ids" @click="select" value="{{ $archive->id }}"></td>
                                    <td>
                                        <a href="{{ Action('Backend\ArchiveController@getEdit',$archive->id) }}">{{ $archive->title }}</a>
                                    </td>
                                    <td>{{ $archive->created_at }}</td>
                                    <td>{{ $archive->updated_at }}</td>
                                    <td>
                                        <div class="uk-float-right uk-link" data-uk-dropdown>
                                            <i class="uk-icon-bars"></i>
                                            <div class="uk-dropdown">
                                                <ul class="uk-nav uk-nav-dropdown uk-nav-parent-icon">
                                                    <li>
                                                        <a href="{{ Action('Frontend\ArchiveController@getShow',$archive->id) }}"
                                                           target="_blank"><i class="uk-icon-list"></i> 预览文章</a></li>
                                                    <li class="uk-nav-divider"></li>
                                                    <li>
                                                        <a href="{{ Action('Backend\ArchiveController@getEdit',$archive->id) }}"><i
                                                                    class="uk-icon-pencil"></i> 编辑文章</a></li>
                                                    <li class="uk-nav-divider"></li>
                                                    <li class="uk-danger">
                                                        <a href="#" @click="delete({{ $archive->id }},$event)"><i
                                                                class="uk-icon-minus-circle"></i> 删除文章</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="uk-margin-top" v-if="ids.length > 0">
                            <button class="uk-button uk-button-danger" @click="deleteAll"><i class="uk-icon-trash-o"></i> 批量删除</button>
                        </div>

                        <div class="uk-margin-top">
                            {!! \Plugins::call('pagination')->simpleCreate($archives)->render() !!}
                        </div>
                    </div>

                </div>
            </div>
            {{--<div class="uk-text-center app-panel">
                <h2><i class="uk-icon-list"></i></h2>
                <p class="uk-text-large">您还未添加任何单页组件</p>

                <a href="{{ Action('Backend\PageController@getCreate') }}" class="uk-button uk-button-success uk-button-large">创建组件</a>
            </div>--}}
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
                disabled: false,
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
                deleteField: function (id) {
                    if (confirm('确定要删除嘛?')) {
                        Vue.http({
                            url: '{{ Action('Backend\ArchiveController@postDeleteField') }}',
                            data: {
                                id: id,
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
                delete: function (id, event) {
                    if (confirm('确定要删除嘛?')) {
                        Vue.http({
                            url: '{{ Action('Backend\ArchiveController@postDelete') }}',
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
                            url: '{{ Action('Backend\ArchiveController@postDelete') }}',
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