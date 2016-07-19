<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>单页组件 - {{ $config['web_name'] }}</title>
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

        [v-cloak] {
            display: none;
        }
    </style>

</head>
<body>

@include('Backend.Common.Nav')

<div class="app-main" v-cloak>
    <div class="app-wrapper">

        <div>
            <nav class="uk-navbar uk-margin-large-bottom">
                <span class="uk-hidden-small uk-navbar-brand">单页组件</span>

                <div class="uk-hidden-small uk-navbar-content">
                    <form class="uk-form uk-margin-remove uk-display-inline-block">
                        <div class="uk-form-icon">
                            <i class="uk-icon-filter"></i>
                            <input type="text" placeholder="搜索标题">
                        </div>
                    </form>
                </div>
                <ul class="uk-navbar-nav">
                    <li>
                        <a href="{{ Action('Backend\PageController@getCreate') }}" title="添加单页组件"
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
                <div class="uk-width-medium-1-1">
                    {{--<div class="uk-width-medium-3-4">--}}

                    <div class="uk-margin-bottom">
                        <span class="uk-badge app-badge">所有组件</span>
                    </div>

                    <div class="app-panel">
                        <table class="uk-table uk-table-striped">
                            <thead>
                            <tr>
                                <th width="10">
                                    <input class="js-select-all"
                                           type="checkbox" @click="selectAll" v-model="allSelected">
                                </th>
                                <th width="60%">标题</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $pages as $page )
                                <tr class="js-multiple-select">
                                    <td>
                                        <input class="js-select" type="checkbox"
                                               v-model="ids" @click="select" value="{{ $page->id }}">
                                    </td>
                                    <td>
                                        <a href="{{ Action('Backend\PageController@getEdit',$page->id) }}">{{ $page->title }}</a>
                                    </td>
                                    <td>
                                        <div class="uk-float-right uk-link" data-uk-dropdown>
                                            <i class="uk-icon-bars"></i>

                                            <div class="uk-dropdown">
                                                <ul class="uk-nav uk-nav-dropdown uk-nav-parent-icon">
                                                    <li>
                                                        <a href="{{ Action('Frontend\PageController@getShow',$page->id) }}"
                                                           target="_blank"><i class="uk-icon-list"></i> 预览组件</a></li>
                                                    <li class="uk-nav-divider"></li>
                                                    <li>
                                                        <a href="{{ Action('Backend\PageController@getEdit',$page->id) }}"><i
                                                                    class="uk-icon-pencil"></i> 编辑组件</a></li>
                                                    <li class="uk-nav-divider"></li>
                                                    <li class="uk-danger"><a
                                                                href="#" @click="delete"
                                                        data-id="{{ $page->id }}"
                                                        ><i class="uk-icon-minus-circle"></i> 删除组件</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="uk-margin-top" v-if="ids.length > 0">
                            <button class="uk-button uk-button-danger" @click="deleteAll"><i
                                    class="uk-icon-trash-o"></i> 批量删除</button>
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
                delete: function (event) {
                    var id = $(event.target).attr('data-id');

                    if (confirm('确定删除嘛?')) {
                        this.$http({
                            url: '{{ Action('Backend\PageController@postDelete') }}',
                            data: {
                                ids: id,
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
                },
                deleteAll: function () {
                    if (confirm('确定删除嘛?')) {
                        this.$http({
                            url: '{{ Action('Backend\PageController@postDelete') }}',
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
