<div class="uk-grid {{ $label }}">
    <div class="uk-width-1-1">
        <div class="uk-grid" for="{{ $label }}" data-uk-grid-margin>
            <div class="uk-width-1-1">
                @if ( isset($value) )
                @foreach ( $value->name as $index => $group )
                <div class="uk-grid field" style="{{ $index == 0 ? 'margin-top: 20px' : null }}">
                    <div class="uk-width-1-3">
                        <div class="uk-form-row">
                            <label class="uk-form-label">名称</label>

                            <div class="uk-form-controls">
                                <input type="text" class="uk-width-1-1" name="{{ $label }}[name][]" value="{{ $group }}">
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-3">
                        <div class="uk-form-row">
                            <label class="uk-form-label">价格 <span class="uk-text-muted">(基币种为美金)</span></label>

                            <div class="uk-form-controls">
                                <input type="text" class="uk-width-1-1" name="{{ $label }}[price][]" value="{{ $value->price[$index] }}">
                            </div>
                        </div>
                    </div>
                    @if ( count( $value->name ) >1 )
                    <div class="uk-width-1-3 uk-text-right">
                        <a class="uk-button uk-button-mini button-delete" onclick="deleteGroup(this);"
                           style="position: relative;top: 22px;display: inline-block;"><i class="uk-icon-remove"></i></a>
                    </div>
                    @else
                    <div class="uk-width-1-3 uk-text-right">
                        <a class="uk-button uk-button-mini button-delete" onclick="deleteGroup(this);"
                           style="position: relative;top: 22px;display: none;"><i class="uk-icon-remove"></i></a>
                    </div>
                    @endif
                </div>
                @endforeach
                @else
                    <div class="uk-grid field">
                        <div class="uk-width-1-3">
                            <div class="uk-form-row">
                                <label class="uk-form-label">名称</label>

                                <div class="uk-form-controls">
                                    <input type="text" class="uk-width-1-1" name="{{ $label }}[name][]">
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-3">
                            <div class="uk-form-row">
                                <label class="uk-form-label">价格 <span class="uk-text-muted">(基币种为美金)</span></label>

                                <div class="uk-form-controls">
                                    <input type="text" class="uk-width-1-1" name="{{ $label }}[price][]">
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-3 uk-text-right">
                            <a class="uk-button uk-button-mini button-delete" onclick="deleteGroup(this);"
                               style="position: relative;top: 22px;display: none;"><i class="uk-icon-remove"></i></a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="uk-grid" style="margin-top: 20px">
            <div class="ul-width-1-1">
                <a class="uk-button" onclick="appendGroup();"><i class="uk-icon-plus"></i> 添加属性</a>
            </div>
        </div>
    </div>
</div>


<template id="groupTemplate">
    <div class="uk-grid field" style="margin-top: 20px">
        <div class="uk-width-1-3">
            <div class="uk-form-row">
                <label class="uk-form-label">名称</label>

                <div class="uk-form-controls">
                    <input type="text" class="uk-width-1-1" name="{{ $label }}[name][]">
                </div>
            </div>
        </div>
        <div class="uk-width-1-3">
            <div class="uk-form-row">
                <label class="uk-form-label">价格 <span class="uk-text-muted">(基币种为美金)</span></label>

                <div class="uk-form-controls">
                    <input type="text" class="uk-width-1-1" name="{{ $label }}[price][]">
                </div>
            </div>
        </div>
        <div class="uk-width-1-3 uk-text-right">
            <a class="uk-button uk-button-mini button-delete" onclick="deleteGroup(this);"
               style="position: relative;top: 22px;display: none;"><i class="uk-icon-remove"></i></a>
        </div>
    </div>
</template >

<script>
    var template = $('#groupTemplate').html();

    function appendGroup() {
        $('.field:last').parent().append(template).find(".button-delete").show();
    }

    function deleteGroup(obj) {
        if ( $('.field').size() > 1 ) {
            $(obj).parent().parent().remove();
            if ( $('.field').size() <= 1 )
                $('.field:last').find(".button-delete").hide();
        }
    }

</script>
