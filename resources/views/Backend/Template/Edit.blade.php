<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>模版编辑 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>

    <script src="{{  asset('assets/vendor/uikit/js/components/accordion.js') }}" type="text/javascript"></script>

    <link href="{{  asset('assets/vendor/codemirror/codemirror.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{  asset('assets/vendor/codemirror/codemirror.css') }}" type="text/css" rel="stylesheet"/>
    <script src="{{ asset('assets/vendor/codemirror/codemirror.js') }}" type="text/javascript"></script>
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
                <a href="{{ Action('Backend\TemplateController@getIndex') }}">模版</a> /
                <span class="uk-text-muted">编辑</span>
            </h1>


            <form class="uk-form" @submit.prevent="submit">
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="app-panel">

                            <div class="uk-form-row">
                                <input class="uk-width-1-1 uk-form-large" type="text" placeholder="模版名称" required
                                       name="name" v-model="name">
                            </div>

                            <div class="uk-form-row">
                                <label class="uk-text-small">模版类型</label>
                                <select name="type" v-model="type">
                                    <option value="1">碎片模版</option>
                                    <option value="2">文章模版</option>
                                </select>

                                <div class="uk-alert">碎片模版不支持文章分类使用.</div>
                            </div>

                            <div class="uk-form-row">

                                <div class="uk-button-group">
                                    <button type="submit" class="uk-button uk-button-primary uk-button-large"
                                            :disabled="disabled">保存
                                    </button>
                                    <a href="{{ Action('Backend\TemplateController@getIndex') }}"
                                       class="uk-button uk-button-large">取消</a>
                                </div>
                                &nbsp;
                            </div>

                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="uk-margin">

                            <strong>模版代码:</strong>
                            <textarea id="editor" name="code"></textarea>

                            <div class="uk-alert uk-alert-info">
                                <i class="uk-icon-exclamation-circle"></i>
                                使用 HTML + Blade 语法书写. 并可以
                                <div class="uk-button-dropdown" data-uk-dropdown="{pos:'top-right'}"
                                     aria-haspopup="true" aria-expanded="false">
                                    <a class="uk-button uk-button-danger">引用</a>

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
                                                    @foreach( $formFields as $field )
                                                        <li>
                                                            <a href="#" @click="insert($event)" data-template="{{ $field->plugin }}" data-type="form">{{ $field->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                表单或模版.
                            </div>
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
        editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
            lineNumbers: true,
            theme: 'neo'
        });

        editor.setSize("100%", "300");

        new Vue({
            el: '.app-main',
            data: {
                disabled: false,
                name: null,
                type: null
            },
            ready: function () {

                this.$http().success(function (template) {
                    this.name = template.name;
                    this.type = template.type;
                    editor.setValue(template.code);

                    editor.on("change", function () {
                        editor.save();
                    });
                });

            },
            methods: {
                submit: function () {

                    editor.save();

                    this.$http({
                        data: $('.uk-form').serialize(),
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    }).success(function (data) {
                        if (data.code == 'success') {
                            UIkit.notify({
                                message: '编辑成功!',
                                status: 'success',
                                timeout: 2000,
                                pos: 'top-center'
                            });
                        } else {
                            UIkit.notify({
                                message: '编辑失败!',
                                status: 'info',
                                timeout: 2000,
                                pos: 'top-center'
                            });
                        }
                    }).error(function () {
                        UIkit.notify({
                            message: '编辑失败!',
                            status: 'info',
                            timeout: 2000,
                            pos: 'top-center'
                        });
                    });

                },
                insert: function (event) {
                    $dataType = $(event.target).attr('data-type');
                    $dataTemplate = $(event.target).attr('data-template');
                    console.log($dataTemplate);
                    if ($dataType == 'template') {
                        editor.replaceRange('{template ' + $dataTemplate + '}', CodeMirror.Pos(editor.lastLine()));
                    } else if ($dataType == 'form') {
                        editor.replaceRange('<form action="/form/plugin/' + $dataTemplate + '" method="post">\n\n<!-- 表单域 -->\n\n</form>', CodeMirror.Pos(editor.lastLine()));
                    }
                }
            }
        });
    });
</script>