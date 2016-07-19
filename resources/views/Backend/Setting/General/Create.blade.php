<div class="uk-modal modal-form">
    <div class="uk-modal-dialog">
        <form class="uk-form">
            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <div class="uk-alert uk-alert-@{{ code }}" data-uk-alert v-if="message != null">
                        <p>@{{ message }}</p>
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" type="text" v-model="form.name" placeholder="变量名称">
                    </div>
                    <div class="uk-form-row uk-margin">
                        <strong>变量名 (英文)</strong>
                    </div>
                    <div class="uk-form-row">
                        <div class="engine">
                            <div class="uk-htmleditor uk-clearfix">
                                <input type="text" class="uk-width-1-1" v-model="form.key">
                            </div>
                        </div>
                    </div>
                    <div class="uk-form-row uk-margin">
                        <strong>变量值</strong>
                    </div>
                    <div class="uk-form-row">
                        <div class="engine">
                            <div class="uk-htmleditor uk-clearfix">
                                <input type="text" class="uk-width-1-1" v-model="form.value">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="uk-button uk-modal-close">取消</button>
            <button type="button" class="uk-button uk-button-primary" :disabled="disabled" @click="save">创建</button>
        </div>
    </div>
</div>