
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文章列表 - {{ $config['web_name'] }}</title>
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

        <div>
            <nav class="uk-navbar uk-margin-bottom">
                <span class="uk-navbar-brand"><a href="{{ Action('Backend\ArchiveController@getIndex') }}">文章组件</a> / {{ $field->name }}</span>
                <ul class="uk-navbar-nav">
                   {{-- <li><a href="" title="Edit collection" data-uk-tooltip="{pos:'bottom'}"><i class="uk-icon-pencil"></i></a></li>
                    <li><a class="uk-text-danger" title="删除文章组" data-uk-tooltip="{pos:'bottom'}"><i class="uk-icon-trash-o"></i></a></li>--}}
                    <li><a href="{{ Action('Backend\ArchiveController@getAdd',$field->id) }}" title="添加文章" data-uk-tooltip="{pos:'bottom'}"><i class="uk-icon-plus-circle"></i></a></li>
                </ul>

                <div class="uk-navbar-content">
                    <form class="uk-form uk-margin-remove uk-display-inline-block" method="post">
                        <div class="uk-form-icon">
                            <i class="uk-icon-filter"></i>
                            <input type="text" placeholder="搜索标题" name="filter">
                        </div>
                    </form>
                </div>

                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav">
                        <li>
                            <a href="" download="qweqweqe.json" title="导出数据" data-uk-tooltip="{pos:'bottom'}">
                                <i class="uk-icon-share-alt"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            @if( count( $archives ) > 0 )
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-1-1">
                        <div class="app-panel">
                            <table id="entries-table" class="uk-table uk-table-striped">
                                <thead>
                                <tr>
                                    <th width="10"><input class="js-select-all" type="checkbox" @click="selectAll" v-model="allSelected"></th>
                                    <th>标题</th>
                                    <th width="15%">创建时间</th>
                                    <th width="15%">修改时间</th>
                                    <th width="10%">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $archives as $archive )
                                    <tr class="js-multiple-select multiple-selected">
                                        <td><input class="js-select" type="checkbox" v-model="ids" @click="select" value="{{ $archive->id }}"></td>
                                        <td>
                                            <div class="uk-text-small">
                                                <a href="{{ Action('Backend\ArchiveController@getEdit',$archive->id) }}">{{ $archive->title }}</a>
                                            </div>
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
                                {{--<button class="uk-button uk-button-primary">Load more...</button>--}}
                                <button class="uk-button uk-button-danger" @click="deleteAll"><i class="uk-icon-trash-o"></i> 批量删除</button>
                            </div>

                        </div>
                    </div>
                </div>
            @else
                    <div class="app-panel uk-margin uk-text-center">
                        <h2><i class="uk-icon-list"></i></h2>
                        <p class="uk-text-large">还没有添加文章.</p>
                        <a href="{{ Action('Backend\ArchiveController@getAdd',$field->id) }}" class="uk-button uk-button-success uk-button-large">添加文章</a>
                    </div>
            @endif

            {{--<div class="app-panel uk-margin uk-text-center">
                <h2><i class="uk-icon-search"></i></h2>
                <p class="uk-text-large">没有搜索到文章.</p>
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
            data:{
                selected: [],
                allSelected: false,
                ids: [],
            },
            methods: {
                delete:function (id, event) {
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
                },
                selectAll:function(){
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
                }
            }
        });
    });
</script>