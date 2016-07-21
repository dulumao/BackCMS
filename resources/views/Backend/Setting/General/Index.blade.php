<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>系统变量 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>

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


        <h1><a href="{{ Action('Backend\SettingController@getIndex') }}">设置</a> / 常规</h1>

        <div class="uk-grid" data-uk-grid-margin data-ng-controller="general-settings">

            <div class="uk-width-medium-1-4">
                <ul class="uk-nav uk-nav-side" data-uk-switcher="{connect:'#settings-general'}">
                    <li><a>系统变量</a></li>
                    <li><a>多语言</a></li>
                    {{--  <li><a href="#REGISTRY">第三方接口</a></li>
                      <li><a href="#SYSTEM">导出接口</a></li>--}}
                </ul>
            </div>

            <div class="uk-width-medium-3-4">
                <div class="app-panel">
                    <div id="settings-general" class="uk-switcher">
                        <div>
                            <span class="uk-badge app-badge">系统变量</span>
                            <hr>
                            <div class="uk-margin">
                                <h3>系统变量</h3>
                                <table class="uk-table">
                                    <tbody>
                                    @foreach( $configures as $configure )
                                        @if ( $configure->type == 1 )
                                            <tr class="uk-form">
                                                <td style="vertical-align: middle;">
                                                    {{ "$configure->name ( $configure->key )" }}
                                                </td>
                                                <td class="uk-width-3-4" style="vertical-align: middle;">
                                                    <input type="text" class="uk-width-1-1" value="{{ $configure->value }}" v-model="form.{{ $configure->key }}">
                                                </td>
                                                <td width="20" style="vertical-align: middle;">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>

                                <h3>自定义变量</h3>
                                <table class="uk-table">
                                    <tbody>
                                    @foreach( $configures as $configure )
                                        @if ( $configure->type == 0 )
                                            <tr class="uk-form">
                                                <td style="vertical-align: middle;">
                                                    {{ "$configure->name ( $configure->key )" }}
                                                </td>
                                                <td class="uk-width-3-4" style="vertical-align: middle;">
                                                    <input type="text" class="uk-width-1-1" value="{{ $configure->value }}" v-model="form.{{ $configure->key }}">
                                                </td>
                                                <td width="20" style="vertical-align: middle;">
                                                    <a href="#" class="uk-text-danger" @click="delete({{ $configure->id }})"><i class="uk-icon-trash-o"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>


                                <div class="uk-margin">
                                    <button class="uk-button uk-button-large uk-button-success" type="button" @click="save" :disabled="disabled">保存</button>
                                    <button class="uk-button uk-button-large uk-button-primary" type="button" @click="create">
                                    <i class="uk-icon-plus-circle"></i>
                                    </button>
                                </div>
                            </div>


                            {{--<hr>--}}

                            {{--<div class="uk-margin">
                                <p><strong>Access the registry values:</strong></p>

                                <span class="uk-badge uk-margin-small-bottom">PHP</span>
                                <highlightcode>&lt;?php $value = get_registry('keyname' [, default]); ?&gt;</highlightcode>
                                <span class="uk-badge uk-margin-small-bottom">Javascript</span>
                                <highlightcode>var value = Cockpit.registry.keyname || default; // with Cockpit.js API</highlightcode>
                            </div>--}}
                        </div>

                        <div>
                            <span class="uk-badge app-badge">多语言</span>
                            <hr>
                                <div class="uk-margin uk-form" ng-if="token">
                                    <label class="uk-badge uk-margin-small-bottom">格式为Yaml文档</label>
                                    <textarea v-model="form.language" class="uk-width-1-1" style="min-height:300px;">{{ $language->value }}</textarea>
                                </div>

                            <button class="uk-button uk-button-large uk-button-success" type="button" @click="save" :disabled="disabled">保存</button>
                        </div>

                        {{--<div>
                            <span class="uk-badge app-badge">第三方接口</span>
                            <hr>

                            <div class="uk-text-center" data-ng-show="!(registry|count)">
                                <h2><i class="uk-icon-flag"></i></h2>
                                <p class="uk-text-large">当前无任何数据</p>

                                <p>
                                    <button class="uk-button uk-button-large uk-button-primary" type="button" ng-click="addRegistryKey()"><i class="uk-icon-plus-circle"></i></button>
                                </p>

                                <p class="uk-text-muted">您可以在这里填写数据接口,方便日后开发调用修改.</p>
                            </div>

                            <div class="uk-margin">
                                <h3>接口</h3>

                                <table class="uk-table">
                                    <tbody>
                                    <tr class="uk-form" ng-repeat="(key, value) in registry">
                                        <td>
                                            <i class="uk-icon-flag"></i>
                                            aaa
                                        </td>
                                        <td class="uk-width-3-4">
                                            <textarea class="uk-width-1-1" placeholder="key value..." ng-model="registry[key]"></textarea>
                                        </td>
                                        <td width="20">
                                            <a href="#" class="uk-text-danger" ng-click="removeRegistryKey(key)"><i class="uk-icon-trash-o"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="uk-margin">
                                    <button ng-show="!emptyRegistry()" class="uk-button uk-button-large uk-button-success" type="button" ng-click="saveRegistry()">Save</button>
                                    <button class="uk-button uk-button-large uk-button-primary" type="button" ng-click="addRegistryKey()"><i class="uk-icon-plus-circle"></i></button>
                                </div>
                            </div>


                            <hr ng-show="(registry|count)">

                            <div class="uk-margin" ng-show="(registry|count)">
                                <p>
                                    <strong>Access the registry values:</strong>
                                </p>

                                <span class="uk-badge uk-margin-small-bottom">PHP</span>
                                <highlightcode>&lt;?php $value = get_registry('keyname' [, default]); ?&gt;</highlightcode>

                                <span class="uk-badge uk-margin-small-bottom">Javascript</span>
                                <highlightcode>var value = Cockpit.registry.keyname || default; // with Cockpit.js API</highlightcode>
                            </div>
                        </div>

                        <div>
                            <span class="uk-badge app-badge">API</span>
                            <hr>

                            <div ng-if="!(tokens|count)" class="uk-margin uk-text-large uk-text-muted uk-text-strong">
                                You have no api token generated yet.                    </div>

                            <div ng-repeat="(token, rules) in tokens" ng-if="(tokens|count)">

                                <div class="uk-text-small">Token:</div>
                                <div class="uk-text-large uk-margin">
                                    <strong ng-if="token">aaaa <a class="uk-text-danger" ng-click="removeToken(token)"><i class="uk-icon-trash-o"></i></a></strong>
                                </div>

                                <div class="uk-margin uk-form" ng-if="token">
                                    <label class="uk-badge uk-margin-small-bottom">Access rules</label>
                                    <textarea codearea class="uk-width-1-1" placeholder="Allow all" style="min-height:300px;" ng-bind="rules" ng-model="tokens[token]"></textarea>
                                </div>

                                <hr>
                            </div>

                            <button ng-show="(tokens|count)" class="uk-button uk-button-large uk-button-success" type="button" ng-click="saveTokens()">Save</button>
                            <button class="uk-button uk-button-large" ng-click="generateToken()">Generate api token</button>
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
    new Vue({
        el: '.app-main',
        data: {
            disabled: false,
            form: {
            @foreach( $configures as $configure )
                {{ $configure->key }}: null,
            @endforeach
                language: null
            }
        },
        methods: {
            save: function() {
                this.$http({
                    data: {
                        @foreach( $configures as $configure )
                        {{ $configure->key }}: this.form.{{ $configure->key }},
                        @endforeach
                        language: this.form.language,
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
                }).error(function () {
                    UIkit.notify({
                        message: '无法保存内容!',
                        status: 'info',
                        timeout: 2000,
                        pos: 'top-center'
                    });
                    this.disabled = false;
                });
            },
            create: function() {

                var self = this;
                self.$http({
                    url: '{{ Action('Backend\SettingController@getCreateGreneral') }}'
                }).success(function (template) {
                    $('body').append(template);

                    new Vue({
                        el: '.modal-form',
                        data: {
                            disabled: false,
                            code: 'success',
                            message: null,
                            form: {
                                name: null,
                                key: null,
                                value: null
                            }
                        },
                        ready: function () {
                            UIkit.modal('.modal-form').show();
                            $('.modal-form').on({
                                'hide.uk.modal': function () {
                                    $(this).remove('.modal-form');
                                }
                            });
                        },
                        methods: {
                            save: function () {
                                var self = this;
                                self.disabled = true;
                                self.$http({
                                    url: '{{ Action('Backend\SettingController@postCreateGreneral') }}',
                                    data: {
                                        name: this.form.name,
                                        key: this.form.key,
                                        value: this.form.value,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    method: 'post'
                                }).success(function (data) {
                                    if (data.code == 'success') {
                                        self.code = 'success';
                                        self.message = '保存成功!';
                                        self.disabled = false;
                                    } else {
                                        self.code = 'danger';
                                        self.message = '无法保存内容!';
                                        self.disabled = false;
                                    }
                                }).error(function () {
                                    self.code = 'danger';
                                    self.message = '无法保存内容!';
                                    self.disabled = false;
                                });

                            }
                        }
                    });

                });
            },
            delete: function( id ) {
                if (confirm('确定要删除嘛?')) {
                    Vue.http({
                        url: '{{ Action('Backend\SettingController@postDeleteGreneral') }}',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        method: 'post'
                    }).success(function (data) {
                        if (data.code == 'success') {
                            $(event.target).parent().parent().parent().parent().remove();
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
            }
        }
    });
</script>


