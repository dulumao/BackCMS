<textarea id="editor" class="uk-width-1-1" name="{{ $label }}" style="height:400px;">{{ $value or null }}</textarea>

<script src="//cdn.bootcss.com/wangeditor/2.1.10/js/wangEditor.min.js"></script>
<link href="//cdn.bootcss.com/wangeditor/2.1.10/css/wangEditor.min.css" rel="stylesheet">

<script>

    $(function(){

        var editor = new wangEditor('editor');

        editor.config.jsFilter = true;

//        editor.config.uploadImgUrl = '/upload';

        editor.config.menus = [
            'source',
            '|',
            'bold',
            'underline',
            'italic',
            'strikethrough',
            'eraser',
            'forecolor',
            'bgcolor',
            '|',
            'quote',
            'fontfamily',
            'fontsize',
            'head',
            'unorderlist',
            'orderlist',
            'alignleft',
            'aligncenter',
            'alignright',
            '|',
            'link',
            'unlink',
            'table',
            'emotion',
            '|',
            'img',
            'video',
            'location',
            '|',
            'undo',
            'redo',
            'fullscreen'
        ];

        editor.config.emotions = {
            'default': {
                title: '默认',  // 组名称
                data: []
            }
        };

        editor.create();

    });

</script>