<!doctype html>
<html class="uk-height-1-1" lang="en" data-base="/" data-route="/">
<head>
    <meta charset="UTF-8">
    <title>提示信息</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>
    <style>
        *, *:before, *:after {
            box-sizing: border-box !important;
            -moz-box-sizing: border-box !important;
        }

        html,
        body {
            background: #eee;
        }

        body {
            padding-top: 100px;
        }

        h1 {
            font-size: 30px;
        }

        #logo {
            margin-bottom: 40px;
            text-align: center;
        }

        .install-page {
            width: 450px;
            max-width: 95%;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            text-align: center;
            border-radius: 3px;
            opacity: 0;
            -webkit-animation-delay: 200ms;
            animation-delay: 200ms;
        }

        .uk-button, .uk-panel-box, .uk-alert {
            border-radius: 3px;
        }
    </style>
</head>
<body>
<div class="install-page app-panel uk-animation-fade">

    <div id="logo">
        <img src="{{ asset('statics/img/backcms.png') }}" width="60" height="60" alt="logo">
    </div>

    <div class="uk-container uk-container-center">

        <h1 class="uk-margin">{{ $message }}</h1>

        <div class="uk-margin-top">
            <a href="{{ Action( 'Frontend\HomeController@getIndex' ) }}"
               class="uk-button uk-button-large uk-button-primary">返回首页</a>
        </div>
    </div>
</div>
</body>
</html>
