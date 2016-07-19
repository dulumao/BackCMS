<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>单页创建 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{  asset('assets/vendor/codemirror/codemirror.css') }}" type="text/css" rel="stylesheet"/>
    <script src="{{ asset('assets/vendor/codemirror/codemirror.js') }}" type="text/javascript"></script>
    {{--<script src="//cdn.bootcss.com/codemirror/5.15.2/mode/php/php.min.js"></script>--}}
    <link href="//cdn.bootcss.com/codemirror/5.15.2/theme/neo.min.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/vue/1.0.24/vue.js"></script>
    <script src="//cdn.bootcss.com/vue-resource/0.7.2/vue-resource.min.js"></script>
</head>
<body>
@include('Backend.Common.Nav')

<div class="app-main">
    <div class="app-wrapper">

        <div>

            <h1>
                <a href="{{ Action('Backend\PageController@getIndex') }}">单页组件</a> /
                <span class="uk-text-muted">创建</span>
            </h1>

            {{--<div class="uk-margin-large-top">
                <div class="uk-text-center uk-width-medium-1-2 uk-container-center">
                    <h2><i class="uk-icon-spinner uk-icon-spin"></i></h2>
                    <p class="uk-text-large">加载信息中...</p>
                </div>
            </div>--}}

            <form class="uk-form" @submit.prevent="submit">
                <div class="uk-grid">
                    <div class="uk-width-medium-4-5">
                        <div class="app-panel">
                            <div class="uk-form-row">
                                <input class="uk-width-1-1 uk-form-large" type="text" placeholder="标题"
                                       v-model="form.title">
                                {{--<div class="uk-margin-top">
                                    <input class="uk-width-1-1 uk-form-blank uk-text-muted" type="text" placeholder="Slug...">
                                </div>--}}
                            </div>

                            {{--<ul class="uk-tab uk-tab-flip uk-margin">
                                <li class="uk-active"><a>模版</a></li>
                            </ul>--}}

                            <div class="uk-form-row">
                                <div class="uk-margin uk-clearfix">

                                    <div class="uk-button-dropdown uk-float-right" data-uk-dropdown="{pos:'top-right'}"
                                         aria-haspopup="true" aria-expanded="false">
                                        <a class="uk-button">引用</a>

                                        <div class="uk-dropdown uk-dropdown-width-2">
                                            <div class="uk-grid uk-dropdown-grid">
                                                <div class="uk-width-1-2">
                                                    <ul class="uk-nav uk-nav-dropdown uk-panel">
                                                        <li class="uk-nav-header">模版列表</li>
                                                        @foreach( $templates as $template )
                                                            <li>
                                                                <a href="#" @click="insert($event)" data-template="{{ $template->name }}" data-type="template">{{ $template->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="uk-width-1-2">
                                                    <ul class="uk-nav uk-nav-dropdown uk-panel">
                                                        <li class="uk-nav-header">表单组件</li>
                                                        @foreach( $forms as $form )
                                                            <li>
                                                                <a href="#" @click="insert($event)" data-template="{{ $form->name }}" data-type="form">{{ $form->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <textarea v-model="form.body" id="editor"></textarea>
                            </div>

                            <div class="uk-form-row">
                                <div class="uk-button-group">
                                    <button type="submit" class="uk-button uk-button-primary uk-button-large"
                                            :disabled="disabled">创建
                                    </button>
                                    <a href="{{ Action('Backend\PageController@getIndex') }}"
                                       class="uk-button uk-button-large">取消</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-5">
                        <div class="uk-form-row">
                            <strong>其他</strong>

                            <div class="uk-margin">
                                <ul id="fields-list" class="uk-nestable">
                                    <li class="uk-nestable-list-item">
                                        <div class="uk-nestable-item uk-nestable-item-table">
                                            <input type="checkbox" v-model="form.enabled"> 线上启用模版
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="uk-margin">
                                <p>解析引擎</p>
                                <select class="uk-width-1-1 uk-margin-bottom" v-model="form.engine"
                                        v-on:change="changeEngine">
                                    {{--<option value="0" selected="selected">MarkDown</option>--}}
                                    {{--<option value="1" selected>Html</option>--}}
                                    <option value="2" selected>Blade</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

            {{--<form class="uk-form" @submit.prevent="submit">
                <div class="uk-grid">
                    <div class="uk-width-3-4">
                        <div class="uk-form-row">
                            <input class="uk-width-1-1 uk-form-large" type="text" placeholder="标题" v-model="form.title">
                        </div>

                        <div class="uk-form-row">
                            <div class="engine">
                                <div class="uk-htmleditor uk-clearfix">
                                    <textarea v-model="form.body"></textarea>
                                </div>
                            </div>
                        </div>


                        <br>
                        <br>

                        <div class="uk-form-row">
                            <div class="uk-button-group">
                                <button type="submit" class="uk-button uk-button-primary uk-button-large"
                                        :disabled="disabled">创建
                                </button>
                                <a href="{{ Action('Backend\PageController@getIndex') }}" class="uk-button uk-button-large">取消</a>
                            </div>
                        </div>

                    </div>
                    <div class="uk-width-1-4">
                        <strong>其他</strong>

                        <div class="uk-margin">
                            <ul id="fields-list" class="uk-nestable">
                                <li class="uk-nestable-list-item">
                                    <div class="uk-nestable-item uk-nestable-item-table">
                                        <input type="checkbox" v-model="form.enabled"> 线上启用模版
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="uk-margin">
                            <p>解析引擎</p>
                            <select class="uk-width-1-1 uk-margin-bottom" v-model="form.engine"
                                    v-on:change="changeEngine">
                                <option value="0" selected="selected">MarkDown</option>
                                <option value="1">Html</option>
                                <option value="2">Blade</option>
                                <option value="3">MiniTemplate</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>--}}
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function () {

        var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
            lineNumbers: true,
            lineWrapping: true,
            theme: 'neo'
        });

        editor.setSize("100%", "500");

        new Vue({
            el: '.app-main',
            data: {
                disabled: false,
                form: {
                    title: null,
                    body: null,
                    enabled: 1,
                    engine: 0,
                }
            },
            methods: {
                changeEngine: function () {
                    if (this.form.engine == 0) {
                        editor.setOption("mode", 'markdown');
                    } else if (this.form.engine == 1) {
                        editor.setOption("mode", 'htmlmixed');
                    } else if (this.form.engine == 2) {
                        editor.setOption("mode", 'php');
                    }
                },

                submit: function () {
                    this.disabled = true;

                    editor.save();

                    this.$http({
                        url: '{{ Url()->current() }}',
                        data: {
                            title: this.form.title,
                            keywords: this.form.keywords,
                            description: this.form.description,
                            body: editor.getValue(),
                            enabled: this.form.enabled,
                            engine: this.form.engine,
                            _token: '{{ csrf_token() }}'
                        },
                        'method': 'post'
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
                                message: '无法保存内容!',
                                status: 'info',
                                timeout: 2000,
                                pos: 'top-center'
                            });
                        }
                        this.disabled = false;
                    }).error(function (data) {
                        UIkit.notify({
                            message: '无法保存内容!',
                            status: 'info',
                            timeout: 2000,
                            pos: 'top-center'
                        });
                        this.disabled = false;
                    });
                },
                insert: function (event) {
                    $dataType = $(event.target).attr('data-type');
                    $dataTemplate = $(event.target).attr('data-template');

                    if ($dataType == 'template') {
                        editor.replaceRange('{template ' + $dataTemplate + '}', CodeMirror.Pos(editor.lastLine()));
                    } else if ($dataType == 'form') {
                        editor.replaceRange('{form ' + $dataTemplate + '}', CodeMirror.Pos(editor.lastLine()));
                    }
                }
            }
        });

    });

</script>
