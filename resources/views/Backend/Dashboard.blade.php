<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>控制中心 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>
    <style>

        .app-dashboard-widget {
            margin-bottom: 25px;
        }

    </style>

    <style type="text/css">

        .date-widget-weekdays span {
            margin-right: 5px;
        }

        .date-widget-weekdays span.active {
            color: #000;
            font-weight: bold;
        }

        .date-widget-clock {
            font-size: 30px;
            margin-top: 20px;
            font-weight: bold;
        }

        #point {
            position: relative;
            padding-left: 10px;
            padding-right: 10px;
            color: #333;
        }
    </style>

    <script type="text/javascript">
        $(function () {
            var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]

            var newDate = new Date();
            newDate.setDate(newDate.getDate());
            $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + newDate.getFullYear());
            $("#weekdays").find('span[data-day="' + (new Date().getDay()) + '"]').addClass('active');

            setInterval(function () {
                var hours = new Date().getHours();
                var minutes = new Date().getMinutes();
                var seconds = new Date().getSeconds();
                $("#hours").html(( hours < 10 ? "0" : "" ) + hours);
                $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
                $("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
                $("#ampm").html((hours >= 12) ? " PM" : " AM");
            }, 1000);
        });
    </script>
</head>
<body>

@include('Backend.Common.Nav')

<div class="app-main">
    <div class="app-wrapper">

        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-2">
                <div class="app-dashboard-widget">
                    <div class="app-panel">

                        <div class="uk-panel app-panel-box docked">
                            <div class="uk-clearfix">
                                <strong>今天</strong>
                            </div>
                        </div>

                        <div class="uk-grid">
                            <div class="uk-width-medium-1-1">
                                <div id="weekdays"
                                     class="uk-text-small uk-text-muted uk-margin uk-text-uppercase date-widget-weekdays">
                                    <span data-day="1">星期一</span>
                                    <span data-day="2">星期二</span>
                                    <span data-day="3">星期三</span>
                                    <span data-day="4">星期四</span>
                                    <span data-day="5">星期五</span>
                                    <span data-day="6">星期六</span>
                                    <span data-day="0">星期日</span>
                                </div>

                                <div class="uk-text-small">
                                    <span>&nbsp;<b id="Date"></b></span>
                                </div>

                                <div class="date-widget-clock">
                                    <i class="uk-icon-clock-o"></i>
                                    <span>&nbsp;<b id="hours"></b>
                                        <b id="point">:</b>
                                        <b id="min"></b>
                                        <b id="point">:</b>
                                        <b id="sec"></b>
                                        <b id="ampm"></b>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-dashboard-widget">
                    <div class="app-panel-secondary">
                        <div class="uk-margin-bottom uk-text-right">
                            <span class="uk-badge app-badge">日志</span>
                        </div>
                        <ul class="uk-list">
                            @foreach( $activities as $activity)
                                <li class="uk-margin-bottom">
                                    <div class="uk-grid uk-grid-divider">
                                        <div class="uk-width-medium-1-5 uk-text-center">
                                            <img class="uk-rounded" src="{{ $activity->getUser->avatar }}" style="width: 40px;height: 40px;" alt="avatar">
                                        </div>
                                        <div class="uk-width-medium-4-5">
                                            <time class="uk-text-small uk-text-muted">{{ $activity->created_at }}</time>
                                            <div class="uk-margin-small-top">{{ $activity->content }}</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="uk-width-medium-1-2">
                <div class="uk-grid uk-grid-width-medium-1-2" data-uk-grid-match="{target:'.app-panel'}">
                    <div class="app-dashboard-widget">
                        <div class="app-panel">
                            <div class="uk-panel app-panel-box docked">
                                <div class="uk-clearfix">
                                    <strong>单页管理</strong>
                                    <span class="uk-float-right uk-badge">{{ count($pages) }}</span>
                                </div>
                            </div>
                            @unless ( count( $pages ) > 0 )
                            <div class="uk-text-center">
                                <h2><i class="uk-icon-list"></i></h2>

                                <p class="uk-text-muted">还未创建任何页面. </p>

                                <a href="{{ Action('Backend\PageController@getCreate') }}"
                                   class="uk-button uk-button-success"
                                   title="添加单页组件" data-uk-tooltip="{pos:'bottom'}">
                                    <i class="uk-icon-plus-circle"></i>
                                </a>
                            </div>
                            @else
                            <div class="uk-margin-bottom">
                                <span class="uk-button-group">
                                    <a class="uk-button uk-button-success uk-button-small"
                                       href="{{ Action('Backend\PageController@getCreate') }}" title="添加单页组件"
                                       data-uk-tooltip="{pos:'bottom'}">
                                        <i class="uk-icon-plus-circle"></i>
                                    </a>
                                    <a class="uk-button app-button-secondary uk-button-small"
                                       href="{{ Action('Backend\PageController@getIndex') }}" title="查看所有组件"
                                       data-uk-tooltip="{pos:'bottom'}">
                                        <i class="uk-icon-ellipsis-h"></i>
                                    </a>
                                </span>
                            </div>
                            <span class="uk-text-small uk-text-uppercase uk-text-muted">列表</span>
                            <ul class="uk-list uk-list-space">
                                @foreach ( $pages as $page )
                                    <li>
                                        <a href="{{ Action('Frontend\PageController@getShow',$page->id) }}">{{ $page->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @endunless
                        </div>
                    </div>
                    <div class="app-dashboard-widget">
                        <div class="app-panel">
                            <div class="uk-panel app-panel-box docked">
                                <div class="uk-clearfix">
                                    <strong>文章管理</strong>

                                    <span class="uk-float-right uk-badge">{{ count($archiveFields) }}</span>
                                </div>
                            </div>
                            @unless ( count( $archiveFields ) > 0 )
                            <div class="uk-text-center">
                                <h2><i class="uk-icon-list"></i></h2>

                                <p class="uk-text-muted">还未创建任何分类. </p>

                                <a href="{{ Action('Backend\ArchiveController@getCreate') }}"
                                   class="uk-button uk-button-success"
                                   title="添加单页组件" data-uk-tooltip="{pos:'bottom'}">
                                    <i class="uk-icon-plus-circle"></i>
                                </a>
                            </div>
                            @else
                            <div class="uk-margin-bottom">
                            <span class="uk-button-group">
                                <a class="uk-button uk-button-success uk-button-small"
                                   href="{{ Action('Backend\ArchiveController@getCreate') }}" title="添加单页组件"
                                   data-uk-tooltip="{pos:'bottom'}">
                                    <i class="uk-icon-plus-circle"></i>
                                </a>
                                <a class="uk-button app-button-secondary uk-button-small"
                                   href="{{ Action('Backend\ArchiveController@getIndex') }}" title="查看所有组件"
                                   data-uk-tooltip="{pos:'bottom'}">
                                    <i class="uk-icon-ellipsis-h"></i>
                                </a>
                            </span>
                            </div>
                            <span class="uk-text-small uk-text-uppercase uk-text-muted">列表</span>
                            <ul class="uk-list uk-list-space">
                                @foreach ( $archiveFields as $field )
                                    <li>
                                        <a href="{{ Action('Backend\ArchiveController@getList',$field->id) }}">{{ $field->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @endunless
                        </div>
                    </div>
                    <div class="app-dashboard-widget">
                        <div class="app-panel">
                            <div class="uk-panel app-panel-box docked">
                                <div class="uk-clearfix">
                                    <strong>表单管理</strong>
                                    <span class="uk-float-right uk-badge">{{ count($formFields) }}</span>
                                </div>
                            </div>
                            @unless ( count( $formFields ) > 0 )
                                <div class="uk-text-center">
                                    <h2><i class="uk-icon-list"></i></h2>

                                    <p class="uk-text-muted">还未创建任何表单. </p>

                                    <a href="{{ Action('Backend\FormController@getCreate') }}"
                                       class="uk-button uk-button-success"
                                       title="添加单页组件" data-uk-tooltip="{pos:'bottom'}">
                                        <i class="uk-icon-plus-circle"></i>
                                    </a>
                                </div>
                                @else
                                    <div class="uk-margin-bottom">
                            <span class="uk-button-group">
                                <a class="uk-button uk-button-success uk-button-small"
                                   href="{{ Action('Backend\FormController@getCreate') }}" title="添加单页组件"
                                   data-uk-tooltip="{pos:'bottom'}">
                                    <i class="uk-icon-plus-circle"></i>
                                </a>
                                <a class="uk-button app-button-secondary uk-button-small"
                                   href="{{ Action('Backend\FormController@getIndex') }}" title="查看所有组件"
                                   data-uk-tooltip="{pos:'bottom'}">
                                    <i class="uk-icon-ellipsis-h"></i>
                                </a>
                            </span>
                                    </div>
                                    <span class="uk-text-small uk-text-uppercase uk-text-muted">列表</span>
                                    <ul class="uk-list uk-list-space">
                                        @foreach ( $formFields as $field )
                                            <li>
                                                <a href="{{ Action('Backend\FormController@getList',$field->id) }}">{{ $field->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @endunless
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
