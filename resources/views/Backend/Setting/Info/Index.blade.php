<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>信息 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>
</head>
<body>

@include('Backend.Common.Nav')

<div class="app-main">
    <div class="app-wrapper">

        <h1>
            <a href="{{ Action('Backend\SettingController@getIndex') }}">设置</a> / 信息
        </h1>

        <div class="uk-grid" data-uk-grid-margin>

            <div class="uk-width-medium-3-4">
                <div class="app-panel">

                    <div id="settings-info" class="uk-switcher">

                        <div>
                            <p><strong><span class="uk-badge app-badge">系统</span></strong></p>
                            <strong>常规</strong>
                            <table class="uk-table uk-table-striped">
                                <tbody>
                                <tr>
                                    <td width="30%">版本</td>
                                    <td>{{ version() }}</td>
                                </tr>
                                <tr>
                                    <td width="30%">视图缓存大小</td>
                                    <td><a id="viewData" title="点击清除缓存" data-uk-tooltip>{{ $totalViewSize }}</a></td>
                                </tr>
                                <tr>
                                    <td width="30%">数据缓存大小</td>
                                    <td><a id="cacheData" title="点击优化数据" data-uk-tooltip>{{ $totalCacheSize }}</a></td>
                                </tr>
                                <tr>
                                    <td width="30%">会话缓存大小</td>
                                    <td><a id="sessionData" title="点击优化数据" data-uk-tooltip>{{ $totalSessionSize }}</a></td>
                                </tr>
                                </tbody>
                            </table>

                            <script>

                               /* $("#clearcache, #vacuumdata").on("click", function(e){

                                    e.preventDefault();

                                    var progress = $('<i class="uk-icon-spinner uk-icon-spin"></i>'),
                                            ele = $(this).hide().after(progress);

                                    App.request('/settings/'+this.id, {}, function(data){
                                        App.notify('Done.');

                                        setTimeout(function(){
                                            ele.text(data.size=="n/a" ? '0 KB':data.size).show();
                                            progress.remove();
                                        }, 500);
                                    }, "json");

                                });*/
                            </script>

                            {{--<strong>邮件系统</strong>


                            <div class="uk-alert">
                                No mailer settings found.
                            </div>--}}

                            <strong>目录</strong>

                            <table class="uk-table uk-table-striped">
                                <thead class="uk-text-small">
                                <tr>
                                    <th>目录</th>
                                    <th>状态</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $testFilesResults as $fileInfo )
                                <tr>
                                    <td class="uk-text-small" style="font-family:monospace;">{{ $fileInfo['file'] }}</td>
                                    @if ( $fileInfo['isWritable'] == 1 )
                                    <td><div class="uk-badge uk-badge-success">可写入</div></td>
                                    @else
                                    <td><div class="uk-badge uk-badge-danger">不可写入</div></td>
                                    @endif
                                </tr>
                                @endforeach
                                </tbody>
                            </table>


                        </div>

                        <div>
                            <p>
                                <strong><span class="uk-badge app-badge">环境</span></strong>
                            </p>
                            <table class="uk-table uk-table-striped">
                                <tbody>
                                <tr>
                                    <td width="30%">版本号</td>
                                    <td>{{ PHP_VERSION }}</td>
                                </tr>
                                <tr>
                                    <td width="30%">SAPI</td>
                                    <td>{{ php_sapi_name() }}</td>
                                </tr>
                                <tr>
                                    <td width="30%">系统</td>
                                    <td>{{ php_uname() }}</td>
                                </tr>
                                <tr>
                                    <td width="30%">扩展</td>
                                    <td>
                                        @foreach(get_loaded_extensions() as $extension)
                                            {{ $extension }}
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td width="30%">内存限制</td>
                                    <td>{{ ini_get('memory_limit') }}</td>
                                </tr>
                                <tr>
                                    <td width="30%">文件上传限制</td>
                                    <td>{{ ini_get('upload_max_filesize') }}</td>
                                </tr>
                                <tr>
                                    <td width="30%">数据上传限制</td>
                                    <td>{{ ini_get('post_max_size') }}</td>
                                </tr>
                                <tr>
                                    <td width="30%">函数禁用限制</td>
                                    <td>{{ ini_get('disable_functions') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>

            <div class="uk-width-medium-1-4">
                <ul class="uk-nav uk-nav-side" data-uk-switcher="{connect:'#settings-info'}">
                    <li><a href="#SYSTEM">系统</a></li>
                    <li><a href="#PHP">环境</a></li>
                </ul>

            </div>

        </div>
    </div>
</div>

</body>
</html>
