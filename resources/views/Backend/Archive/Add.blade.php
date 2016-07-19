<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加文章 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
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

        {{--<div id="entry-versions" class="uk-offcanvas">
            <div class="uk-offcanvas-bar">
                <div class="uk-panel">

                    <div data-ng-show="versions.length">
                        <h3 class="uk-panel-title">版本</h3>

                        <ul class="uk-list uk-list-space" data-ng-show="versions.length">
                            <li class="uk-flex" data-ng-repeat="version in versions">

                                <div><i class="uk-icon-clock-o uk-margin-small-right"></i></div>

                                <div class="uk-flex-item-1">
                                    <strong> asd</strong>
                                    <div class="uk-text-small">
                                        <a class="uk-link uk-text-muted" href="#v-asd">清空编辑</a>
                                    </div>
                                </div>

                            </li>
                        </ul>
                        <br>

                        <div class="uk-button-group">
                            <button type="button" class="uk-button uk-button-danger" data-ng-click="clearVersions()" title="Clear version history" data-uk-tooltip="{pos:'bottom-left'}"><i class="uk-icon-trash-o"></i></button>
                            <button type="button" class="uk-button uk-button-primary" onclick="UIkit.offcanvas.hide()" title="Close versions" data-uk-tooltip="{pos:'bottom-left'}">Cancel</button>
                        </div>
                    </div>

                    <div class="uk-text-muted uk-text-center" data-ng-show="!versions.length">
                        <div class="uk-margin-small-bottom"><i class="uk-icon-clock-o"></i></div>
                        <div>Empty</div>
                    </div>
                </div>
            </div>
        </div>--}}


        <nav class="uk-navbar uk-margin-large-bottom">
            <span class="uk-navbar-brand">
              <a href="{{ Action('Backend\ArchiveController@getIndex') }}">文章组件</a> /
              <a href="{{ Action('Backend\ArchiveController@getList',$field->id) }}">{{ $field->name }}</a> / 添加
              </span>
            {{--<div class="uk-navbar-content uk-form">
                <select ng-model="locale" data-uk-tooltip title="Language">
                    <option value="">中文</option>
                </select>
            </div>

            <div class="uk-navbar-content">
                <a href="#entry-versions" data-uk-offcanvas><i class="uk-icon-clock-o"></i> 回滚版本 <span class="uk-badge">asd</span></a>
            </div>--}}
        </nav>

        <form class="uk-form" @submit.prevent="save">
            {{ csrf_field() }}
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-3-4">
                    <div class="app-panel">
                        <div class="uk-form-row">
                            <label class="uk-text-small">
                                标题 <span>*</span>

                                <div class="uk-badge">系统默认</div>
                            </label>

                            <div class="uk-margin-top">
                                @Tags([
                                    'type' => 'text',
                                    'label' => 'title'
                                ])
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-text-small">
                                关键词
                                <div class="uk-badge">系统默认</div>
                            </label>

                            <div class="uk-margin-top">
                                @Tags([
                                    'type' => 'text',
                                    'label' => 'keywords'
                                ])
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-text-small">
                                描述
                                <div class="uk-badge">系统默认</div>
                            </label>

                            <div class="uk-margin-top">
                                @Tags([
                                    'type' => 'text',
                                    'label' => 'description'
                                ])
                            </div>
                        </div>
                        @foreach( $attributes as $attribute )
                            <div class="uk-form-row">
                                <label class="uk-text-small">
                                    {{ $attribute->name }}
                                    @if ( $attribute->required )
                                        <span>*</span>
                                    @endif
                                    <div class="uk-badge uk-badge-success">自定义</div>
                                </label>
                                {{--<div class="uk-text-small uk-text-danger uk-float-right uk-animation-slide-top">提示</div>--}}
                                <div class="uk-margin-top">
                                    @Tags([
                                        'type' => $attribute->type,
                                        'label' => $attribute->label,
                                        'attach' => $attribute
                                    ])
                                </div>
                            </div>
                        @endforeach
                        <div class="uk-form-row">
                            <button type="submit" class="uk-button uk-button-primary uk-button-large">创建</button>
                            <a href="{{ Action('Backend\ArchiveController@getList',$field->id) }}"
                               class="uk-button uk-button-large">取消</a>
                        </div>
                    </div>
                </div>

                <div class="uk-width-medium-1-4">
                    <div class="uk-margin">
                        <p>列表模版</p>
                        <select class="uk-width-1-1 uk-margin-bottom" disabled>
                            <option selected>{{ $field->getListTemplate->name }}</option>
                        </select>
                    </div>
                    <div class="uk-margin">
                        <p>内容模版</p>
                        <select class="uk-width-1-1 uk-margin-bottom" disabled>
                            <option selected>{{ $field->getShowTemplate->name }}</option>
                        </select>
                    </div>
                </div>

                {{--<div class="uk-width-medium-1-4">
                    <div class="uk-form-row" data-ng-repeat="field in fieldsInArea('side')">

                        <label class="uk-text-small">
                            <span ng-if="field.localize"><i class="uk-icon-comments-o"></i></span>
                            asd
                            <span ng-if="field.required">*</span>
                        </label>

                        <div class="uk-text-small uk-text-danger uk-float-right uk-animation-slide-top" data-ng-if="field.error">asd</div>

                        <contentfield options="asdasd" ng-model="entry[getFieldname(field)]"></contentfield>
                    </div>

                </div>--}}
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
            data: {},
            methods: {
                save: function () {

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


                }
            }
        });

    });
</script>
