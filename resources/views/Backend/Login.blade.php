<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登录系统 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>
    <script src="{{ asset('assets/vendor/uikit/js/components/form-password.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/uikit/js/components/form-password.js') }}" type="text/javascript"></script>
    <script>
        $(function () {

            var loginbox = $(".app-login-box"),
                    container = loginbox.find(".app-login-box-container"),
                    profile = $("#profile"),
                    form = $("form").on("submit", function (e) {
                        e.preventDefault();

                        loginbox.addClass("app-loading");

                        $.post(form.attr("action"), form.serialize(), function (data) {

                            setTimeout(function () {

                                loginbox.removeClass("app-loading");
                                container.removeClass("uk-animation-shake");

                                if (data && data.code == 'success') {

                                    form.hide();
                                    profile.find("img").attr("src", data.auth.avatar);
                                    profile.find("span").html(data.auth.nickname);
                                    profile.removeClass('uk-hidden');

                                    setTimeout(function () {

                                        container.addClass("uk-animation-slide-top uk-animation-reverse").width();

                                        setTimeout(function () {
                                            location.href = data.redirect;
                                        }, 500);

                                    }, 550);

                                } else {

                                    setTimeout(function () {
                                        container.addClass("uk-animation-shake");
                                        UIkit.notify(data.message, 'danger');
                                    }, 50);
                                }

                            }, 450);

                        }, 'json');
                    });
        });
    </script>
</head>
<body>
<div class="uk-container uk-container-center">
    <div class="uk-animation-fade app-login-box">
        <div class="app-login-box-container">
            <form class="uk-form" method="post" action="{{ Action('Backend\\LoginController@postCheck') }}">
                {{ csrf_field() }}
                <p class="uk-text-center uk-margin-large-bottom app-login-logo" style="position:relative;">
                    <i class="uk-icon-spinner uk-icon-spin"></i>

                    <img src="{{ asset('statics/img/backcms.png') }}" width="50" height="50" alt="logo">
                </p>

                <div class="uk-form-row">
                    <input name="username" class="uk-form-large uk-width-1-1" type="text" placeholder="账号名称">
                </div>
                <div class="uk-form-row">
                    <div class="uk-form-password uk-width-1-1">
                        <input name="password" class="uk-form-large uk-width-1-1" type="password"
                               placeholder="账号密码">
                        <a href="" class="uk-form-password-toggle" data-uk-form-password="{lblShow:'显示', lblHide:'隐藏'}">显示</a>
                    </div>
                </div>

                <div class="uk-form-row">
                    <button class="uk-button uk-button-large uk-button-primary uk-width-1-1">登录</button>
                </div>
            </form>
            <div id="profile" class="uk-text-center uk-animation-fade uk-hidden">
                <p>
                <div class="uk-thumbnail uk-rounded">
                    <img alt="avatar" width="60" height="60" style="width:60px;height:60px;">
                </div>
                </p>
                <p class="uk-text-large"><strong>欢迎登录系统!</strong></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
