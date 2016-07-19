<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cockpit</title>
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
    <script src="https://cdn.jsdelivr.net/vue/latest/vue.js"></script>
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
                    <div class="uk-width-3-4">
                        <div class="uk-form-row">
                            <input class="uk-width-1-1 uk-form-large" type="text" placeholder="标题" v-model="form.title" value="{{ $page->title }}">
                        </div>

                        <div class="uk-form-row uk-margin" v-if="form.template != 0">
                            <strong>SEO优化</strong>
                        </div>

                        <div class="uk-form-row" v-if="form.template != 0">
                            <ul class="uk-list">
                                <li class="uk-margin-bottom uk-clearfix">

                                    <div class="uk-panel app-panel">

                                        <div class="uk-grid uk-grid-small">
                                            <div class="uk-width-1-1">
                                                <input class="uk-width-1-1 uk-form-blank" type="text" placeholder="关键词"
                                                       v-model="form.keywords" value="{{ $page->keywords }}">
                                            </div>
                                            <div class="uk-width-1-1">
                                                <input class="uk-width-1-1 uk-form-blank" type="text" placeholder="描述"
                                                       v-model="form.description" value="{{ $page->description }}">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="uk-form-row uk-margin">
                            <strong>其他</strong>
                        </div>

                        <div class="uk-form-row">
                            <ul class="uk-list">
                                <li class="uk-margin-bottom uk-clearfix">

                                    <div class="uk-panel app-panel">

                                        <div class="uk-grid uk-grid-small">
                                            <div class="uk-width-1-1">
                                                <input class="uk-width-1-1 uk-form-blank" type="text" placeholder="备注"
                                                       v-model="form.mark" value="{{ $page->mark }}">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="engine">
                            <div class="uk-htmleditor uk-clearfix">
                                <textarea id="edit-code" v-model="form.body" >{{ $page->body }}</textarea>
                            </div>
                        </div>
                        <br>
                        <br>

                        <div class="uk-form-row">
                            <div class="uk-button-group">
                                <button type="submit" class="uk-button uk-button-primary uk-button-large"
                                        :disabled="disabled">保存
                                </button>
                                <a href="" class="uk-button uk-button-large">取消</a>
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
                                <option value="0">MarkDown</option>
                                <option value="1" selected="selected">Html</option>
                                <option value="2">Blade</option>
                                <option value="3">MiniTemplate</option>
                            </select>
                        </div>

                        <div class="uk-margin">
                            <p>解析模版</p>
                            <select class="uk-width-1-1 uk-margin-bottom" v-model="form.template"
                                    v-on:change="changeEngine">
                                <option value="0" selected="selected" label="不使用">不使用</option>
                                @foreach( $templates as $template )
                                    <option value="{{ $template->id }}">{{ $template->mark }}</option>
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

        @if ( $page->engine == 0 )
        var mode = 'markdown';
        var markdown = false;
        @elseif ( $page->engine == 1 )
        var mode = 'html';
        var markdown = false;
        @else
        var mode = 'php';
        var markdown = false;
        @endif

        var htmlEditor = UIkit.htmleditor('textarea', {
            markdown: markdown,
            codemirror: {
                mode: mode,
//                theme: 'seti',
                lineNumbers: true
            }
        });

        new Vue({
            el: '.app-main',
            data: {
                disabled: false,
                form: {
                    title: null,
                    keywords: null,
                    description: null,
                    mark: null,
                    body: null,
                    enabled: 1,
                    engine: 0,
                    template: 0
                }
            },
            methods: {
                changeEngine: function () {
                    if (this.form.engine == 0) {
                        htmlEditor.htmleditor
                                .find('.uk-htmleditor-toolbar')
                                .show()
                                .parent()
                                .parent()
                                .find('.uk-htmleditor-button-preview')
                                .show();
                        htmlEditor.enableMarkdown();
                    } else if (this.form.engine == 1) {
                        htmlEditor.htmleditor
                                .find('.uk-htmleditor-toolbar')
                                .show()
                                .parent()
                                .parent()
                                .find('.uk-htmleditor-button-preview')
                                .show();
                        htmlEditor.disableMarkdown();
                    } else if (this.form.engine == 2) {
                        htmlEditor.disableMarkdown();
                        htmlEditor.htmleditor
                                .find('.uk-htmleditor-toolbar')
                                .hide()
                                .parent()
                                .parent()
                                .find('.uk-htmleditor-button-preview')
                                .hide();
                        htmlEditor.htmleditor.find('.uk-htmleditor-button-code a').html('Blade');
                        htmlEditor.editor.setOption('mode', 'php');
                    } else if (this.form.engine == 3) {
                        htmlEditor.disableMarkdown();
                        htmlEditor.htmleditor
                                .find('.uk-htmleditor-toolbar')
                                .hide()
                                .parent()
                                .parent()
                                .find('.uk-htmleditor-button-preview')
                                .hide();
                        htmlEditor.htmleditor.find('.uk-htmleditor-button-code a').html('MiniTemplate');
                        htmlEditor.editor.setOption('mode', 'php');
                    }
                },

                submit: function () {
                    this.disabled = true;
                    this.$http({
                        url: '{{ Url()->current() }}',
                        data: {
                            title: this.form.title,
                            keywords: this.form.keywords,
                            description: this.form.description,
                            mark: this.form.mark,
                            body: this.form.body,
                            enabled: this.form.enabled,
                            engine: this.form.engine,
                            template: this.form.template,
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
                }
            }
        });

    });

</script>
