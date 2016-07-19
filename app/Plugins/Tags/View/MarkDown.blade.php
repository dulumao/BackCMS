<textarea id="editor" class="uk-width-1-1" name="{{ $label }}" style="height:400px;">{{ $value or null }}</textarea>

<link href="{{  asset('assets/vendor/codemirror/codemirror.css') }}" type="text/css" rel="stylesheet"/>
<link href="{{  asset('assets/vendor/codemirror/codemirror.css') }}" type="text/css" rel="stylesheet"/>
<script src="{{ asset('assets/vendor/codemirror/codemirror.js') }}" type="text/javascript"></script>
<link href="//cdn.bootcss.com/codemirror/5.15.2/theme/neo.min.css" rel="stylesheet">

<script>

    $(function () {
        editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
            lineNumbers: true,
            mode: 'gfm',
            theme: 'neo'
        });

        editor.setSize("100%", "300");
    });

</script>