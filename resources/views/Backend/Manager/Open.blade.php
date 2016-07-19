<div class="uk-modal modal-form">
    <div class="uk-modal-dialog uk-modal-dialog uk-modal-dialog-large">
        <div class="uk-modal-header">
            <i class="uk-icon-pencil"></i> &nbsp; <strong class="uk-text-small filename">{{ basename($full) }}</strong>
        </div>
        <textarea id="editor" style="height: 1000px">{{ $raw }}</textarea>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="uk-button uk-modal-close">取消</button>
            <button type="button" class="uk-button uk-button-primary ">保存</button>
        </div>
    </div>
</div>
