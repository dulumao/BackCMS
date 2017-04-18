# BackCMS (初心)

基于 Laravel 的CMS,功能非常简洁.

包含功能
* 单页组件 (用于创建广告宣传等页面)
* 文章组件 (顾名思义,可以自定义字段,后台添加文章,目前支持字段: 文本,Html编辑器,Markdown编辑器,多选框,日期,时间,单图片上传,无限图片上传,以及自定义模版字段)
* 表单组件 (自定义扩充前台提交的表单数据,用户登录,文件上传等,后台已支持原数据展示,也可指定自定义解析)
* 多角色权限 (基于rbac的角色管理权限)
* 系统文件组件 (项目文件增删改查)
* 多语言支持 (支持后台yaml配置语言文件,路由自动识别切换)

## 安装方式
* 下载文件
* composer update
* cp .env.example .env && ./artisan key:generate
* 编辑 .env 文件中数据库连接
* 访问 http://xxxxx/ 提示安装
* 安装成功后,会在 /storage/app 生成 installed 文件


## 卸载数据
* 访问 /storage/app 下 installed 文件 ,里面有卸载密码.
* 访问 http://xxxxx/install/uninstall/卸载密码
* 卸载成功

## 如果还有问题...

如果还有问题,就我擦了

后台模版基于 cockpit ,系统开发 Laravel 5.2 + vue