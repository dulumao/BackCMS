<div class="uk-grid {{ $label }}">
    <div class="uk-width-1-1">
        <ul class="uk-grid" for="{{ $label }}" data-uk-grid-margin>
            @if ( isset($value) )
            @foreach( $value as $img )
                <li class="uk-width-1-6">
                    <figure class="uk-overlay uk-overlay-hover">
                        <img src="{{ $img }}">
                        <input type="hidden" name="{{ $label }}[]" value="{{ $img }}">
                        <figcaption class="uk-overlay-panel uk-flex uk-flex-center uk-flex-middle uk-text-center">
                            <a class="uk-button uk-button-danger" onclick="deleteImage(this);">删除</a></figcaption>
                    </figure>
                </li>
            @endforeach
            @endif
            {{--<li class="uk-width-1-6">
                <figure class="uk-overlay uk-overlay-hover">
                    <img src="{{ asset('theme/img/placeholder_600x400.svg') }}">
                    <figcaption class="uk-overlay-panel uk-flex uk-flex-center uk-flex-middle uk-text-center">
                        <button class="uk-button uk-button-danger">删除</button>
                    </figcaption>
                </figure>
            </li>--}}
        </ul>
        <div class="uk-grid" style="margin-top: 20px">
            <div class="ul-width-1-1">
                <span class="uk-button uk-form-file" data-uk-tooltip="" title="上传图片">
                    <input class="js-upload-select" type="file" multiple="true">
                    <i class="uk-icon-plus"></i> 上传图片
                </span>
            </div>
        </div>
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

                    $("[for={{ $label }}]").append('<li class="uk-width-1-6"><figure class="uk-overlay uk-overlay-hover"><img src="' + data.image + '"><input type="hidden" name="{{ $label }}[]" value="' + data.image + '"><figcaption class="uk-overlay-panel uk-flex uk-flex-center uk-flex-middle uk-text-center"><a class="uk-button uk-button-danger" onclick="deleteImage(this);">删除</a></figcaption></figure></li>');
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
                            name: $(obj).parent().parent().find("img").attr('src'),
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
                            $(obj).parent().parent().parent().remove();
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
