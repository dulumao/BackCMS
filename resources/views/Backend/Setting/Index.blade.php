<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>设置 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>
    <style>

        .app-panel > div {
            text-align: center;
        }

        .app-panel > div  *[class*=uk-icon], .app-panel > div img {
            font-size: 40px;
            line-height: 60px;
        }

        .app-panel > div img {
            width: 40px;
            height: 40px;
        }

    </style>

</head>
<body>

@include('Backend.Common.Nav')

<div class="app-main">
    <div class="app-wrapper">

        <h1>设置</h1>

        <div class="app-panel">

            <div class="uk-text-left">
                <span class="uk-badge app-badge">系统</span>
            </div>

            <hr>

            <div class="uk-grid uk-grid-width-medium-1-6" uk-grid-margin uk-grid-match>

                <div class="uk-margin-bottom">
                    <div>
                        <i class="uk-icon-cogs"></i>
                    </div>
                    <div class="uk-text-truncate">
                        <a href="{{ Action('Backend\SettingController@getGeneral') }}">常规</a>
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <div>
                        <i class="uk-icon-group"></i>
                    </div>
                    <div class="uk-text-truncate">
                        <a href="{{ Action('Backend\SettingController@getAdmins') }}">管理员</a>
                    </div>
                </div>

          {{--      <div class="uk-margin-bottom">
                    <div>
                        <i class="uk-icon-code-fork"></i>
                    </div>
                    <div class="uk-text-truncate">
                        <a href="{{ Action('Backend\SettingController@getAddons') }}">插件</a>
                    </div>
                </div>--}}

                {{--<div class="uk-margin-bottom">
                    <div>
                        <i class="uk-icon-database"></i>
                    </div>
                    <div class="uk-text-truncate">
                        <a href="{{ Action('Backend\SettingController@getDatabase') }}">数据</a>
                    </div>
                </div>--}}

                <div class="uk-margin-bottom">
                    <div>
                        <i class="uk-icon-archive"></i>
                    </div>
                    <div class="uk-text-truncate">
                        <a href="{{ Action('Backend\SettingController@getBackups') }}">备份</a>
                    </div>
                </div>

              {{--  <div class="uk-margin-bottom">
                    <div>
                        <i class="uk-icon-fire"></i>
                    </div>
                    <div class="uk-text-truncate">
                        <a href="{{ Action('Backend\SettingController@getUpdate') }}">更新</a>
                    </div>
                </div>--}}

                <div class="uk-margin-bottom">
                    <div>
                        <i class="uk-icon-info-circle"></i>
                    </div>
                    <div class="uk-text-truncate">
                        <a href="{{ Action('Backend\SettingController@getInfo') }}">信息</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script charset="utf-8" src="/i18n-js"></script>


</body>
</html>
