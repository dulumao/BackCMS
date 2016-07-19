
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>表单组件 - {{ $config['web_name'] }}</title>
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
            <nav class="uk-navbar uk-margin-large-bottom">
                <span class="uk-hidden-small uk-navbar-brand">表单组件</span>
                <div class="uk-hidden-small uk-navbar-content">
                    <form class="uk-form uk-margin-remove uk-display-inline-block">
                        <div class="uk-form-icon">
                            <i class="uk-icon-filter"></i>
                            <input type="text" placeholder="搜索表单名字">
                        </div>
                    </form>
                </div>
                <ul class="uk-navbar-nav">
                    <li><a href="{{ Action('Backend\FormController@getCreate') }}" title="添加表单" data-uk-tooltip="{pos:'right'}"><i class="uk-icon-plus-circle"></i></a></li>
                </ul>
            </nav>

            <div class="app-panel">
                <table class="uk-table uk-table-striped" multiple-select="{model:forms}">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>元数据</th>
                        <th>创建时间</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $forms as $form )
                    <tr class="js-multiple-select">
                        <td>
                            {{ $form->id }}
                        </td>
                        <td>
                            @PrettyJSON($form->body)
                        </td>
                        <td>{{ $form->created_at }}</td>
                        <td>
                            <div class="uk-link uk-float-right" data-uk-dropdown>
                                <i class="uk-icon-bars"></i>
                                <div class="uk-dropdown">
                                    <ul class="uk-nav uk-nav-dropdown uk-nav-parent-icon">
                                            <li class="uk-danger"><a href="#" @click="delete({{ $form->id }},$event)"><i class="uk-icon-minus-circle"></i> 删除数据</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{--<div class="uk-text-center app-panel" data-ng-show="forms && !forms.length">
                <h2><i class="uk-icon-inbox"></i></h2>
                <p class="uk-text-large">您还没有创建任何模版.</p>

                <a href="//" class="uk-button uk-button-success uk-button-large">创建模版</a>
            </div>--}}

        </div>
    </div>
</div>

</body>
</html>
