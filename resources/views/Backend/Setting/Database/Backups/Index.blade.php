<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>备份 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>

    <script src="//cdn.bootcss.com/vue/1.0.24/vue.js"></script>
    <script src="//cdn.bootcss.com/vue-resource/0.7.2/vue-resource.min.js"></script>
    <style>
        [v-cloak] {
            /*display: none;*/
        }
    </style>
</head>
<body>

@include('Backend.Common.Nav')

<div class="app-main">
    <div class="app-wrapper">
        <div data-ng-controller="backups" v-cloak>

            <nav class="uk-navbar uk-margin-large-bottom">
                <span class="uk-navbar-brand"><a href="{{ Action('Backend\SettingController@getIndex') }}">设置</a> / 备份</span>
            </nav>

            <div class="uk-grid" data-uk-grid-margin>

                <div class="uk-width-medium-2-3">
                    <div class="app-panel">
                        @if( count($files) > 0 )
                            <table class="uk-table uk-table-striped">
                                <thead>
                                <th width="20">&nbsp;</th>
                                <th>日期</th>
                                <th>大小</th>
                                <th width="20">&nbsp;</th>
                                </thead>
                                <tbody>
                                @foreach( $files as $file )
                                    <tr>
                                        <td class="uk-text-center"><i class="uk-icon-archive"></i></td>
                                        <td>
                                            {{ $file['modifiedTime'] }}
                                            <div class="uk-text-small uk-text-muted">{{ $file['name'] }}</div>
                                        </td>
                                        <td style="vertical-align: middle;">{{ $file['fileSize'] }}</td>
                                        <td class="uk-text-right" style="vertical-align: middle;">
                                            <div data-uk-dropdown>
                                                <i class="uk-icon-bars"></i>
                                                <div class="uk-dropdown uk-dropdown-flip uk-text-left">
                                                    <ul class="uk-nav uk-nav-dropdown">
                                                        <li><a href="/storage/backups/ss.zip" @click.prevent="download"><i
                                                                        class="uk-icon-cloud-download"></i> 下载</a></li>
                                                        <li><a href="#"><i class="uk-icon-trash-o"></i> 删除</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else

                        <div class="uk-text-center">
                            <h2><i class="uk-icon-archive"></i></h2>

                            <p class="uk-text-large">还未创建任何备份.</p>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="uk-width-medium-1-3">
                    <button class="uk-button uk-button-large uk-button-primary" @click="create">创建新备份</button>
                    <hr>
                    <div class="uk-text-truncate uk-text-small">
                        备份路径:
                        <p class="uk-margin">
                            <strong><i class="uk-icon-folder-open"></i> {{ $backupsPath }}</strong>
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function () {
        new Vue({
            el: '.app-main',
            methods: {
                create: function () {
                    this.$http({
                                data: {
                                    _token: '{{ csrf_token() }}',
                                },
                                method: 'post'
                            })
                            .success(function (data) {
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
                            })
                            .error(function () {
                                UIkit.notify({
                                    message: '创建失败!',
                                    status: 'info',
                                    timeout: 2000,
                                    pos: 'top-center'
                                });
                            });
                },
                download: function () {
                    alert("as");
                }
            }
        });
    });
</script>
