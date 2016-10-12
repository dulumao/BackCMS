<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加字段 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>
    <script src="{{ asset('assets/vendor/uikit/js/components/htmleditor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/marked.js') }}" type="text/javascript"></script>
    <link href="{{  asset('assets/vendor/codemirror/codemirror.css') }}" type="text/css" rel="stylesheet"/>
    <script src="{{ asset('assets/vendor/codemirror/codemirror.js') }}" type="text/javascript"></script>
    {{--<script src="//cdn.bootcss.com/codemirror/5.15.2/mode/php/php.min.js"></script>--}}
    <link href="//cdn.bootcss.com/codemirror/5.15.2/theme/seti.min.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/vue/1.0.24/vue.js"></script>
    <script src="//cdn.bootcss.com/vue-resource/0.7.2/vue-resource.min.js"></script>
</head>
<body>
@include('Backend.Common.Nav')

<div class="app-main">
    <div class="app-wrapper">

        <div>

            <h1>
                <a href="{{ Action('Backend\ArchiveController@getIndex') }}">文章组件</a> /
                <span class="uk-text-muted">创建</span>
            </h1>

            <form class="uk-form" @submit.prevent="save">
                {{ csrf_field() }}
                <div class="uk-grid">
                    <div class="uk-width-3-4">
                        <div class="uk-form-row">
                            <input class="uk-width-1-1 uk-form-large" type="text" placeholder="分类名称" name="archiveName">
                        </div>

                        <div class="uk-form-row uk-margin">
                            <strong>字段</strong>
                        </div>

                        <div class="uk-form-row">
                            <ul id="fields" class="uk-list">

                            </ul>

                            <button type="button" class="uk-button uk-button-success" @click="add">
                                <i class="uk-icon-plus-circle" title="添加字段"></i>
                            </button>
                        </div>

                        <br>
                        <br>

                        <div class="uk-form-row">
                            <div class="uk-button-group">
                                <button type="submit" class="uk-button uk-button-primary uk-button-large" :disabled="disabled">创建
                                </button>
                                <a href="{{ Action('Backend\PageController@getIndex') }}"
                                   class="uk-button uk-button-large">取消</a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-4">
                        <div class="uk-margin">
                            <p>父分类</p>
                            <select class="uk-width-1-1 uk-margin-bottom" name="parent_id">
                                <option value="0">{{ '无' }}</option>
                                @foreach( $parents as $parent )
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-margin">
                            <p>列表模版</p>
                            <select class="uk-width-1-1 uk-margin-bottom" name="list_template">
                                @foreach( $templates as $template )
                                    <option value="{{ $template->id }}" {{ $template->name == '文章列表' ? 'selected' : null }} >{{ $template->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-margin">
                            <p>内容模版</p>
                            <select class="uk-width-1-1 uk-margin-bottom" name="show_template">
                                @foreach( $templates as $template )
                                <option value="{{ $template->id }}" {{ $template->name == '文章内容' ? 'selected' : null }}>{{ $template->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
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
                fieldTotal: 0,
                form: {
                    fields: []
                }
            },
            ready: function () {
                this.add();
            },
            methods: {
                add: function () {
                    this.$http({
                        url: '{{ Action('Backend\ArchiveController@postAttributes')  }}',
                        data: {
                            field: this.fieldTotal,
                            _token: '{{ csrf_token() }}'
                        },
                        method: 'post'
                    })
                    .success(function (source) {
                        var parentThis = this;

                        var Atttibute = Vue.extend({
                            template: source
                        });
                        var atttibute = new Atttibute({
                            data: {
                                selectShow: 'displayShow',
                                selectHide: 'displayHide',
                                attribute: {
                                    name: null,
                                    type: null,
                                    label: null,
                                    default: null,
                                    required: false
                                }
                            },
                            methods: {
                                toggle: function(event) {
                                    var atttibute = $(event.target).parent().parent().parent().parent();
                                    atttibute.find('.options').toggle();
                                },
                                close: function(event) {
                                    var atttibute = $(event.target).parent().parent().parent().parent();
                                    atttibute.remove();
                                },
                                group: function() {

                                }
                            }
                        });

                        atttibute.$mount().$appendTo('#fields');
                        this.fieldTotal++;

                    })
                    .error(function () {
                        UIkit.notify({
                            message: '获取失败!',
                            status: 'info',
                            timeout: 5000,
                            pos: 'top-center'
                        });
                    });
                },
                save: function () {

                    this.$http({
                        data: $('.uk-form').serialize(),
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    }).success(function(data){
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
                    }).error(function(){
                        UIkit.notify({
                            message: '创建失败!',
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