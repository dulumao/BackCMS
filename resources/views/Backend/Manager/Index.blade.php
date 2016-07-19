<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件管理 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{  asset('assets/vendor/codemirror/codemirror.css') }}" type="text/css" rel="stylesheet"/>
    <script src="{{ asset('assets/vendor/codemirror/codemirror.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/uikit/js/components/upload.js') }}" type="text/javascript"></script>
    <link href="//cdn.bootcss.com/codemirror/5.15.2/theme/seti.min.css" rel="stylesheet">

    <script src="//cdn.bootcss.com/vue/1.0.24/vue.js"></script>
    <script src="//cdn.bootcss.com/vue-resource/0.7.2/vue-resource.min.js"></script>
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
</head>
<body>

@include('Backend.Common.Nav')

<div class="app-main" v-cloak>
    <div class="app-wrapper">

        <div>
            <div class="uk-navbar">
                <span class="uk-hidden-small uk-navbar-brand">文件管理</span>
                <ul class="uk-navbar-nav">
                    {{-- <li class="uk-parent" data-uk-dropdown>
                         <a><i class="uk-icon-star"></i><span class="uk-hidden-small">&nbsp; 标记</span></a>
                         <div class="uk-dropdown uk-dropdown-navbar">
                             <ul id="mmbookmarks" class="uk-nav uk-nav-navbar uk-nav-parent-icon">
                                 <li class="uk-nav-header">文件夹</li>
                                 <li><a href="#bbb" draggable="true"><i class="uk-icon-folder-o"></i> bbb</a></li>
                                 <li class="uk-nav-header">文件</li>
                                 <li><a draggable="true"><i class="uk-icon-file-o"></i> bbb</a></li>
                             </ul>
                             <div class="uk-text-muted">您没有任何标记.</div>
                         </div>
                     </li>--}}
                    <li><a href="#" @click="createFolder"><i class="uk-icon-plus-circle"></i><span
                                class="uk-hidden-small">&nbsp; 文件夹</span></a></li>
                    <li><a href="#" @click="createFile"><i class="uk-icon-plus-circle"></i><span
                                class="uk-hidden-small">&nbsp; 文件</span></a>
                    </li>
                </ul>

                <div class="uk-navbar-flip">
                    <div class="uk-navbar-content">
                        <span class="uk-button uk-form-file" data-uk-tooltip title="上传文件">
                            <input id="js-upload-select" type="file" multiple="true" root="/">
                            <i class="uk-icon-plus"></i>
                        </span>
                    </div>
                </div>
            </div>
            <br>

            <div class="app-panel">
                <div class="uk-panel app-panel-box docked">
                    <ul class="uk-breadcrumb">
                        <li @click="load(null)">
                        <a href="#/">
                            <i class="uk-icon-home"></i>
                        </a>
                        </li>
                        <li v-for="name in root.split('{{ DIRECTORY_SEPARATOR }}')">
                            <a href="#" title="切换目录" @click="navigation(name)">@{{ name }}</a>
                        </li>
                        {{-- <li>
                             <a href="#" title="切换目录"></a>
                         </li>--}}
                    </ul>
                </div>

                <div class="uk-navbar uk-margin-large-bottom">

                    <div class="uk-navbar-content">
                        {{--<div class="uk-button-group uk-margin-right">
                            <button class="uk-button" title="Table mode" data-uk-tooltip="{pos:'bottom'}"><i
                                        class="uk-icon-th-list"></i></button>
                            <button class="uk-button" title="List mode" data-uk-tooltip="{pos:'bottom'}"><i
                                        class="uk-icon-th"></i></button>
                        </div>--}}
                        <button class="uk-button uk-button-danger" v-if="ids.length > 0" @click="deleteAllFiles"><i class="uk-icon-trash-o"></i></button>
                    </div>
                    {{--<div class="uk-navbar-content">
                        <span class="uk-alert uk-alert-warning"><span class="uk-icon-bolt"></span> Folders hidden via filter: <strong>bbb</strong></span>
                        <span class="uk-alert uk-alert-warning"><span class="uk-icon-bolt"></span> Files hidden via filter: <strong>bbb</strong></span>
                    </div>--}}
                    <div class="uk-navbar-flip">
                        <div class="uk-navbar-content uk-form">
                            {{--  <div class="uk-form-icon uk-hidden-small">
                                  <i class="uk-icon-filter"></i>
                                  <input type="text" placeholder="过滤名字">
                              </div>--}}
                            <div class="uk-button-group">
                                <button class="uk-button" title="所有文件"
                                        data-uk-tooltip="{pos:'bottom'}" @click="load(root,'all')">所有
                                </button>
                                <button class="uk-button" title="仅目录"
                                        data-uk-tooltip="{pos:'bottom'}" @click="load(root,'folder')">
                                <i class="uk-icon-folder-o"></i> <span
                                        class="uk-text-small">文件夹 @{{ folderTotal }}</span>
                                </button>
                                <button class="uk-button" title="仅文件"
                                        data-uk-tooltip="{pos:'bottom'}" @click="load(root,'file')">
                                <i class="uk-icon-file-o"></i> <span
                                        class="uk-text-small">文件 @{{ fileTotal }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--<ul class="uk-grid uk-grid-small" data-ng-show="mode=='list' && dir && (dir.folders.length || dir.files.length)">
                    <li class="uk-grid-margin uk-width-medium-1-5 uk-width-1-1" ng-repeat="folder in dir.folders track by folder.path" data-type="folder" data-ng-hide="(viewfilter=='files' || !matchName(folder.name))">
                        <div class="app-panel">
                            <span class="js-select"><input type="checkbox" ng-model="selected[folder.path]"></span>
                            <div class="mm-type mm-type-folder">
                                <i class="uk-icon-folder-o"></i>
                            </div>
                            <div class="app-panel-box docked-bottom uk-text-center">
                                <div class="uk-text-truncate mm-caption" title="bbb"><a href="#bbb" ng-click="updatepath(folder.path)">bbb</a></div>
                                <ul class="uk-subnav uk-subnav-line uk-flex-center mm-actions">
                                    <li><a ng-click="addBookmark(folder)" title="Bookmark folder"><i class="uk-icon-star"></i></a></li>
                                    <li><a ng-click="action('rename', folder)" title="Rename folder"><i class="uk-icon-text-width"></i></a></li>
                                    <li><a ng-click="action('remove', folder)" title="Delete folder"><i class="uk-icon-minus-circle"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="uk-grid-margin uk-width-medium-1-5 uk-width-1-1" ng-repeat="file in dir.files track by file.path" data-ng-hide="(viewfilter=='folders' || !matchName(file.name))">
                        <div class="app-panel">
                            <span class="js-select"><input type="checkbox" ng-model="selected[file.path]"> </span>
                            <div class="mm-type mm-type-file">
                                <i class="uk-icon-file-o" media-preview="bbb"></i>
                            </div>
                            <div class="app-panel-box docked-bottom uk-text-center">
                                <div class="uk-text-truncate mm-caption" title="bbb"><a ng-click="open(file)">bbb</a></div>
                                <ul class="uk-subnav uk-subnav-line uk-flex-center mm-actions">
                                    <li><a ng-click="addBookmark(file)" title="Bookmark file"><i class="uk-icon-star"></i></a></li>
                                    <li><a ng-click="action('rename', file)" title="Rename file"><i class="uk-icon-text-width"></i></a></li>
                                    <li><a ng-click="action('download', file)" title="Download file"><i class="uk-icon-paperclip"></i></a></li>
                                    <li ng-if="(file.ext == 'zip')"><a ng-click="action('unzip', file)" title="Unzip file"><i class="uk-icon-archive"></i></a></li>
                                    <li><a ng-click="action('remove', file)" title="Delete file"><i class="uk-icon-minus-circle"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>--}}


                <table class="uk-table uk-table-hover media-table" v-if="folderTotal > 0 || fileTotal > 0">
                    <thead>
                    <tr>
                        <th width="20" ng-click="selectAllToggle()">
                            <input class="js-select-all" type="checkbox" @click="selectAll" v-model="allSelected">
                        </th>
                        <th width="20"></th>
                        <th>文件名</th>
                        <th class="uk-text-right" width="100">大小</th>
                        <th class="uk-text-right" width="150">最后修改时间</th>
                        <th class="uk-text-right" width="50">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="file in files">
                        <td>
                            <input class="js-select" type="checkbox" v-model="ids" @click="select" :value="file.name">
                        </td>
                        <td>
                            <i class="uk-icon-folder-o" v-if="file.type == 'folder'"></i>
                            <i class="uk-icon-file-o" v-if="file.type == 'file'"></i>
                        </td>
                        <td>
                            <div class="uk-text-truncate" :title="file.name">
                                <a href="#" @click.prevent="load(file)">@{{ file.name }}</a>
                            </div>
                        </td>
                        <td class="uk-text-right">@{{ file.fileSize }}</td>
                        <td class="uk-text-right">@{{ file.modifiedTime }}</td>
                        <td class="uk-text-right">
                            <div class="mm-actions" data-uk-dropdown="{mode:'click'}">
                                <i class="uk-icon-bars"></i>

                                <div class="uk-dropdown uk-dropdown-flip uk-text-left">
                                    <ul class="uk-nav uk-nav-dropdown uk-nav-parent-icon">
                                        <li class="uk-nav-header uk-text-truncate">
                                            <i class="uk-icon-folder-o"></i> @{{ file.name }}</li>
                                        {{--<li><a title="Bookmark folder"><i class="uk-icon-star"></i> 标记</a></li>--}}
                                        <li>
                                            <a title="重新命名" @click="renameFile($event)" :filename="file.name">
                                            <i class="uk-icon-text-width"></i> 重命名
                                            </a>
                                        </li>
                                        <li class="uk-nav-divider"></li>
                                        <li class="uk-danger">
                                            <a title="Delete folder" @click="deleteFile($event)" :filename="file.name"><i
                                                    class="uk-icon-minus-circle"></i> 删除</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="uk-margin uk-text-center" v-if="folderTotal <= 0 && fileTotal <= 0">
                    <h2><i class="uk-icon-folder-open-o"></i></h2>

                    <p class="uk-text-large">无任何文件</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    var select = null;

    new Vue({
        el: '.app-main',
        data: {
            folderTotal: 0,
            fileTotal: 0,
            root: null,
            files: null,
            selected: [],
            allSelected: false,
            ids: [],
        },
        ready: function () {
            this.load(null);

            select = UIkit.uploadSelect($("#js-upload-select"), {
                action: '{{ Action('Backend\ManagerController@postFile') }}',
                allow: '*.*',
                type: 'json',
                single: false,
                param: 'files[]',
                params: {
                    root: '/',
                    _token: '{{ csrf_token() }}',
                },
                complete: function (data) {
                    if (data.code == 'success') {
                        UIkit.notify({
                            message: '上传成功!',
                            status: 'success',
                            timeout: 2000,
                            pos: 'top-center'
                        });
                    } else {
                        UIkit.notify({
                            message: '上传失败!',
                            status: 'info',
                            timeout: 2000,
                            pos: 'top-center'
                        });
                    }
                }
            });
        },
        methods: {
            selectAll: function () {
                var self = this;
                self.ids = [];

                if (!self.allSelected) {
                    $.each($('.js-select'), function (i, obj) {
                        self.ids.push($(obj).val());
                    });
                }
            },
            select: function () {
                this.allSelected = false;
            },
            load: function (file, onlyType) {

                if (file != null && file.type == 'folder') {
                    this.root = file.directory + file.name;
                    select.options.params.root = this.root;
                } else if (file != null && file.type == 'file') {
                    this.$http({
                                url: '{{ Action('Backend\ManagerController@postOpenFile')  }}',
                                data: {
                                    fileType: file.fileType,
                                    full: file.full,
                                    _token: '{{ csrf_token() }}',
                                },
                                method: 'post'
                            })
                            .success(function (data) {
                                if (data.code == 'success') {
                                    $('body').append(data.raw);

                                    new Vue({
                                        el: '.modal-form',
                                        data: {
                                            disabled: false,
                                            code: 'success',
                                        },
                                        ready: function () {
                                            UIkit.modal('.modal-form').show();
                                            $('.modal-form').on({
                                                'hide.uk.modal': function () {
                                                    $(this).remove('.modal-form');
                                                }
                                            });
                                            var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
                                                lineNumbers: true,
                                                theme: 'seti',
                                                height: '1000px',
                                                mode: data.fileType
                                            });

                                            editor.setSize("100%", "1000");
                                            /*var htmlEditor = UIkit.htmleditor('textarea', {
                                             codemirror: {
                                             'theme': 'seti',
                                             lineNumbers: true
                                             }
                                             });

                                             htmlEditor.editor.setOption('mode', data.fileType);*/
                                        },
                                        methods: {
                                            save: function () {
                                                alert("Asd");
                                            }
                                        }
                                    });
                                } else {
                                    UIkit.notify({
                                        message: '不支持此文件!',
                                        status: 'info',
                                        timeout: 2000,
                                        pos: 'top-center'
                                    });
                                }
                            })
                            .error(function () {
                                UIkit.notify({
                                    message: '打开失败!',
                                    status: 'info',
                                    timeout: 2000,
                                    pos: 'top-center'
                                });
                            });
                    return;
                } else if (typeof(file) == 'string') {
                    this.root = file;
                } else {
                    this.root = null;
                }

                var data = {
                    root: this.root,
                    _token: '{{ csrf_token() }}',
                };

                if (onlyType != null) {
                    data['onlyType'] = onlyType;
                }

                this.$http({
                            url: '{{ Action('Backend\ManagerController@postRoot')  }}',
                            data: data,
                            method: 'post'
                        })
                        .success(function (data) {
                            if (data.code == 'success') {
                                this.folderTotal = data.folderTotal;
                                this.fileTotal = data.fileTotal;
                                this.files = data.files;

                                try {

                                    this.files.sort(function (a, b) {
                                        if (b.fileSize == null) return 1;
                                        else if (a.fileSize != b.fileSize) return -1;
                                        else return 0;
                                    })

                                } catch (exception) {
                                }


                                UIkit.notify({
                                    message: '加载成功!',
                                    status: 'success',
                                    timeout: 2000,
                                    pos: 'top-center'
                                });
                            } else {
                                this.folderTotal = data.folderTotal;
                                this.fileTotal = data.fileTotal;
                                this.files = null
                            }
                        })
                        .error(function () {
                            UIkit.notify({
                                message: '加载失败!',
                                status: 'info',
                                timeout: 2000,
                                pos: 'top-center'
                            });
                        });
            },
            navigation: function (root) {
                var roots = this.root.split('{{ DIRECTORY_SEPARATOR }}');
                var newRoot = Array();

                for (var i = 0; i < roots.length; i++) {
                    newRoot.push(roots[i]);
                    if (roots[i] == root) break;
                }

                this.root = newRoot.join('{{ DIRECTORY_SEPARATOR }}');
                this.load(this.root);
            },
            createFolder: function () {
                var name = prompt('请输入文件夹名称', '');

                if (name) {
                    this.$http({
                                url: '{{ Action('Backend\ManagerController@postCreateFolder')  }}',
                                data: {
                                    name: name,
                                    root: this.root,
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
                                    message: '加载失败!',
                                    status: 'info',
                                    timeout: 2000,
                                    pos: 'top-center'
                                });
                            });
                }
            },
            createFile: function () {
                var name = prompt('请输入文件名称', '');

                if (name) {
                    this.$http({
                                url: '{{ Action('Backend\ManagerController@postCreateFile')  }}',
                                data: {
                                    name: name,
                                    root: this.root,
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
                }
            },
            renameFile: function (event) {
                var oldname = $(event.target).attr('filename');
                var name = prompt('请输入新名称', oldname);

                if (name && name != oldname) {
                    this.$http({
                                url: '{{ Action('Backend\ManagerController@postRenameFile')  }}',
                                data: {
                                    oldname: oldname,
                                    name: name,
                                    root: this.root,
                                    _token: '{{ csrf_token() }}',
                                },
                                method: 'post'
                            })
                            .success(function (data) {
                                if (data.code == 'success') {
                                    UIkit.notify({
                                        message: '命名成功!',
                                        status: 'success',
                                        timeout: 2000,
                                        pos: 'top-center'
                                    });
                                } else {
                                    UIkit.notify({
                                        message: '命名失败!',
                                        status: 'info',
                                        timeout: 2000,
                                        pos: 'top-center'
                                    });
                                }
                            })
                            .error(function () {
                                UIkit.notify({
                                    message: '命名失败!',
                                    status: 'info',
                                    timeout: 2000,
                                    pos: 'top-center'
                                });
                            });
                }
            },
            deleteFile: function (event) {
                var name = $(event.target).attr('filename');

                if (confirm('确定要删除嘛?')) {
                    this.$http({
                                url: '{{ Action('Backend\ManagerController@postDeleteFile')  }}',
                                data: {
                                    name: name,
                                    root: this.root,
                                    _token: '{{ csrf_token() }}',
                                },
                                method: 'post'
                            })
                            .success(function (data) {
                                if (data.code == 'success') {
                                    UIkit.notify({
                                        message: '删除成功!',
                                        status: 'success',
                                        timeout: 2000,
                                        pos: 'top-center'
                                    });
                                } else {
                                    UIkit.notify({
                                        message: '删除失败!',
                                        status: 'info',
                                        timeout: 2000,
                                        pos: 'top-center'
                                    });
                                }
                            })
                            .error(function () {
                                UIkit.notify({
                                    message: '删除失败!',
                                    status: 'info',
                                    timeout: 2000,
                                    pos: 'top-center'
                                });
                            });
                }

            },
            deleteAllFiles: function () {
                if (confirm('确定要删除嘛?')) {
                    this.$http({
                                url: '{{ Action('Backend\ManagerController@postDeleteFile')  }}',
                                data: {
                                    name: this.ids,
                                    root: this.root,
                                    _token: '{{ csrf_token() }}',
                                },
                                method: 'post'
                            })
                            .success(function (data) {
                                if (data.code == 'success') {
                                    UIkit.notify({
                                        message: '删除成功!',
                                        status: 'success',
                                        timeout: 2000,
                                        pos: 'top-center'
                                    });
                                } else {
                                    UIkit.notify({
                                        message: '删除失败!',
                                        status: 'info',
                                        timeout: 2000,
                                        pos: 'top-center'
                                    });
                                }
                            })
                            .error(function () {
                                UIkit.notify({
                                    message: '删除失败!',
                                    status: 'info',
                                    timeout: 2000,
                                    pos: 'top-center'
                                });
                            });
                }

            }
        }
    });
</script>
