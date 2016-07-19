<div class="uk-grid {{ $label }}">
    <div class="uk-width-1-1">
        <ul class="uk-grid" for="{{ $label }}" data-uk-grid-margin>
            <li class="uk-width-1-3">
                <figure class="uk-overlay uk-overlay-hover">
                    @if ( isset($value) && !empty($value) )
                        <img src="{{ $value }}">
                        <input type="hidden" name="{{ $label }}" value="{{ $value }}">
                    @else
                        <img src="{{ asset('theme/img/placeholder_600x400.svg') }}">
                        <input type="hidden" name="{{ $label }}">
                    @endif
                    <figcaption class="uk-overlay-panel uk-flex uk-flex-center uk-flex-middle uk-text-center">
                        <div class="uk-button-group">
                            <a class="uk-button uk-button-danger button-delete"
                               onclick="deleteImage(this);" style="{{ !isset($value) || empty($value) ? 'display:none' : null }}">删除</a>
                            <span class="uk-button uk-form-file uk-button-danger" data-uk-tooltip="" title="上传图片">
                                        <input class="js-upload-select" type="file" multiple="true">
                                        <i class="uk-icon-plus"></i> 上传图片
                                </span>
                        </div>
                    </figcaption>
                </figure>
            </li>
        </ul>
    </div>
</div>

<script src="{{ asset('assets/vendor/uikit/js/components/upload.js') }}" type="text/javascript"></script>


<script>

    $(function () {
        select = UIkit.uploadSelect($(".{{ $label  }} .js-upload-select"), {
            action: '{{ Action('Backend\ManagerController@postImage') }}',
            allow: '*.*',
            type: 'json',
            single: true,
            param: 'image',
            params: {
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

                    $("[for={{ $label }}]").find("input[type=hidden]").val(data.image).end().find("img").attr('src', data.image).end().find('.button-delete').show();
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
    });

    function deleteImage(obj) {

        if (confirm('确定要删除嘛?')) {
            $.ajax({
                        url: '{{ Action('Backend\ManagerController@postDeleteFile')  }}',
                        data: {
                            root: 'public',
                            name: $(obj).parent().parent().parent().find("img").attr('src'),
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
                            $(obj).parent().parent().parent().find("img").attr('src', '{{ asset('theme/img/placeholder_600x400.svg') }}').end().find('input[type=hidden]').val("").end().find('.button-delete').hide();
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

</script>
