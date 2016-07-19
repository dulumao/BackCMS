<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>表单创建 - {{ $config['web_name'] }}</title>
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
                <a href="{{ Action('Backend\FormController@getIndex') }}">表单</a> /
                <span class="uk-text-muted">创建</span>
            </h1>


            <form class="uk-form" @submit.prevent="submit">
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="app-panel">

                            <div class="uk-form-row">
                                <input class="uk-width-1-1 uk-form-large" type="text" placeholder="表单名称" required
                                       name="name">
                            </div>

                            <div class="uk-form-row">
                                <input class="uk-width-1-1 uk-form-large" type="text" placeholder="表单接收器名称 Plugin/Form"
                                       name="plugin" v-model="plugin" @keyup="update">

                                <div class="uk-alert">可以开发插件用来处理表单提交的数据.</div>
                            </div>

                            <div class="uk-form-row">
                                <div class="uk-button-group">
                                    <button type="submit" class="uk-button uk-button-primary uk-button-large"
                                            :disabled="disabled">创建
                                    </button>
                                    <a href="{{ Action('Backend\FormController@getIndex') }}"
                                       class="uk-button uk-button-large">取消</a>
                                </div>
                                &nbsp;
                            </div>

                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="uk-margin">
                            <strong>示例代码:</strong>
                            <textarea id="editor"></textarea>
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
        var editor = null;

        new Vue({
            el: '.app-main',
            data: {
                disabled: false,
                plugin: null
            },
            ready: function () {
                editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
                    lineNumbers: true,
                    theme: 'neo'
                });


                editor.setSize("100%", "300");
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

                },
                update: function () {
                    editor.setValue('<form action="/form/plugin/' + this.plugin + '">\n\n<!-- 表单域 -->\n\n</form>');
                }
            }
        });
    });
</script>