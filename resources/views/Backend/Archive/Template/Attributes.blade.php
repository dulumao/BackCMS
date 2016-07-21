<li class="uk-margin-bottom uk-clearfix">
    <div class="uk-panel app-panel">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-3-4">
                <input class="uk-width-1-1 uk-form-blank" type="text" placeholder="字段名称" name="attributeName[]">
            </div>
            <div class="uk-width-1-4 uk-text-right" style="line-height: 30px">
                <a @click="toggle($event)" style="
                    -webkit-appearance: none
                ;
                    margin: 0
                ;
                    border: none
                ;
                    overflow: visible
                ;
                    text-transform: none
                ;
                    padding: 0
                ;
                    background: transparent
                ;
                    display: inline-block
                ;
                    -moz-box-sizing: content-box
                ;
                    box-sizing: content-box
                ;
                    width: 20px
                ;
                    line-height: 20px
                ;
                    text-align: center
                ;
                    vertical-align: middle
                ;
                "><i class="uk-icon-cog"></i></a>
                <a @click="close($event)" class="uk-close"></a>
            </div>
        </div>

        <div class="app-panel-box docked-bottom options">
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-1-3">
                    <label class="uk-text-small">字段类型</label>
                    <select class="uk-width-1-1" title="字段类型" name="attributeType[]" v-model="attribute.type">
                        <option value="text" selected="selected">文本</option>
                        {{--<option value="1">选择</option>--}}
                        {{--<option value="2">布尔</option>--}}
                        <option value="html">Html</option>
                        <option value="markdown">Markdown</option>
                        <option value="boolean">布尔</option>
                        <option value="select">多选</option>
                        <option value="datetime">日期</option>
                        <option value="time">时间</option>
                        <option value="image">单图片</option>
                        <option value="images">多图片</option>
                        <option value="template">自定义模版</option>
                        {{--<option value="6">Html (WYSIWYG)</option>
                        <option value="7">代码</option>
                        <option value="8">日期</option>
                        <option value="9">时间</option>
                        <option value="10">图片</option>
                        <option value="11">Tags</option>
                        <option value="12">多选</option>
                        <option value="13">链接</option>
                        <option value="14">影音</option>--}}
                    </select>
                </div>
                <div class="uk-width-1-3">
                    <label class="uk-text-small">字段标签</label>
                    <input class="uk-width-1-1" type="text" placeholder="字段标签" name="attributeLabel[]">
                </div>
                <div class="uk-width-1-3">
                    <label class="uk-text-small">默认值</label>
                    <input type="text" class="uk-width-1-1" placeholder="默认值" name="attributeDefault[]">
                </div>

                <div class="uk-width-1-1 uk-grid-margin">

                    <strong class="uk-text-small">更多选项</strong>
                    <hr>
                    <div class="uk-form uk-form-horizontal">

                        <div class="uk-form-row">
                            <label class="uk-form-label">必填</label>

                            <div class="uk-form-controls">
                                <input type="checkbox" name="attributeRequired[]" value="1">
                            </div>
                        </div>

                        <style>
                            .displayShow {
                                display: block;
                            }

                            .displayHide {
                                display: none;
                            }
                        </style>

                        <div class="uk-form-row" v-bind:class="attribute.type == 'select' ? selectshow : selectHide">
                            <label class="uk-form-label">选项</label>

                            <div class="uk-form-controls">
                                <input class="uk-form-blan uk-width-1-1" type="text" name="attributeSelect[]"
                                       placeholder="竖线分割选项" title="竖线分割选项"
                                       data-uk-tooltip="">
                            </div>
                        </div>

                        <div class="uk-form-row" v-bind:class="attribute.type == 'template' ? selectshow : selectHide">
                            <label class="uk-form-label">对应模版</label>

                            <div class="uk-form-controls">
                                <input class="uk-form-blan uk-width-1-1" type="text" name="attributeTemplate[]"
                                       placeholder="例如 Text" title="对应解析模版"
                                       data-uk-tooltip="">
                            </div>
                        </div>

                    </div>
                </div>

                {{--<div class="uk-width-1-1 uk-grid-margin">

                    <strong class="uk-text-small">更多选项</strong>
                    <hr>
                    <div class="uk-form uk-form-horizontal">

                        <div class="uk-form-row">
                            <label class="uk-form-label">必填</label>
                            <div class="uk-form-controls">
                                <input type="checkbox">
                            </div>
                        </div>

                        <div class="uk-form-row ng-scope">
                            <label class="uk-form-label">唯一</label>
                            <div class="uk-form-controls">
                                <input type="checkbox">
                            </div>
                        </div>

                        <div class="uk-form-row">
                            <label class="uk-form-label">选项</label>
                            <div class="uk-form-controls">
                                <input class="uk-form-blank" type="text" placeholder="选项名字" title="竖线分割选项" data-uk-tooltip="">
                            </div>
                        </div>

                        <div class="uk-form-row">
                            <label class="uk-form-label">语法</label>
                            <div class="uk-form-controls">
                                <select title="" data-uk-tooltip="">
                                    <option value="text">Text</option>
                                    <option value="css">CSS</option>
                                    <option value="htmlmixed">Html</option>
                                    <option value="javascript">Javascript</option>
                                    <option value="markdown">Markdown</option>
                                </select>
                            </div>
                        </div>

                        <div class="uk-form-row">
                            <label class="uk-form-label">多选</label>
                            <div class="uk-form-controls">
                                <span class="uk-text-muted uk-text-small">可使用的字段:</span>
                                <div class="uk-scrollable-box uk-panel-box uk-margin-small-top">
                                    <div>
                                        <input type="checkbox"> Text
                                    </div>
                                    <div>
                                        <input type="checkbox"> Html
                                    </div>
                                    <div>
                                        <input type="checkbox"> Markdown
                                    </div>
                                    <div>
                                        <input type="checkbox"> Location
                                    </div>
                                    <div>
                                        <input type="checkbox"> Html (WYSIWYG)
                                    </div>
                                    <div>
                                        <input type="checkbox"> code
                                    </div>
                                    <div>
                                        <input type="checkbox"> Date
                                    </div>
                                    <div>
                                        <input type="checkbox"> Time
                                    </div>
                                    <div>
                                        <input type="checkbox"> Gallery
                                    </div>
                                    <div>
                                        <input type="checkbox"> Tags
                                    </div>
                                    <div>
                                        <input type="checkbox"> Collection link
                                    </div>
                                    <div>
                                        <input type="checkbox"> Media
                                    </div>
                                    <div>
                                        <input type="checkbox"> Region
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>--}}
            </div>
        </div>
    </div>
</li>
