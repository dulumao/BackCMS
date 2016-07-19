<?php

use Illuminate\Database\Seeder;

class AdminPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'admin_permissions' )->insert( [
            [ 'name' => 'Archive.Index', 'label' => '文章管理' ],
            [ 'name' => 'Archive.Add', 'label' => '文章添加' ],
            [ 'name' => 'Archive.Create', 'label' => '属性添加' ],
            [ 'name' => 'Archive.Delete', 'label' => '文章删除' ],
            [ 'name' => 'Archive.Edit', 'label' => '文章修改' ],
            [ 'name' => 'Archive.List', 'label' => '文章列表' ],
            [ 'name' => 'Archive.Attributes', 'label' => '添加属性' ],
            [ 'name' => 'Archive.Delete.Field', 'label' => '删除分类' ],
            [ 'name' => 'Page.Index', 'label' => '单页管理' ],
            [ 'name' => 'Page.Delete', 'label' => '单页删除' ],
            [ 'name' => 'Page.Create', 'label' => '单页添加' ],
            [ 'name' => 'Page.Edit', 'label' => '单页修改' ],
            [ 'name' => 'Page.List', 'label' => '单页列表' ],
            [ 'name' => 'Template.Index', 'label' => '模版管理' ],
            [ 'name' => 'Template.Create', 'label' => '模版添加' ],
            [ 'name' => 'Template.Delete', 'label' => '模版删除' ],
            [ 'name' => 'Template.Edit', 'label' => '模版修改' ],
            [ 'name' => 'Template.List', 'label' => '模版列表' ],
            [ 'name' => 'Form.Index', 'label' => '表单管理' ],
            [ 'name' => 'Form.Create', 'label' => '表单添加' ],
            [ 'name' => 'Form.Delete', 'label' => '表单删除' ],
            [ 'name' => 'Form.Edit', 'label' => '表单修改' ],
            [ 'name' => 'Form.List', 'label' => '表单列表' ],
            [ 'name' => 'Setting.Index', 'label' => '设置管理' ],
            [ 'name' => 'Setting.General', 'label' => '常规' ],
            [ 'name' => 'Setting.Create.Greneral', 'label' => '添加变量' ],
            [ 'name' => 'Setting.Delete.Greneral', 'label' => '删除变量' ],
            [ 'name' => 'Setting.Admins', 'label' => '管理员' ],
            [ 'name' => 'Setting.Create.Admin', 'label' => '添加管理员' ],
            [ 'name' => 'Setting.Admin.Edit', 'label' => '编辑管理员' ],
            [ 'name' => 'Setting.Admin.Groups', 'label' => '权限组' ],
            [ 'name' => 'Setting.Create.Admin.Groups', 'label' => '创建权限组' ],
            [ 'name' => 'Setting.Save.Admin.Groups', 'label' => '保存权限组' ],
            [ 'name' => 'Setting.Delete.Admin.Groups', 'label' => '删除权限组' ],
            [ 'name' => 'Setting.Delete.Admin', 'label' => '删除管理员' ],
            [ 'name' => 'Setting.Backups', 'label' => '备份' ],
            [ 'name' => 'Setting.Info', 'label' => '信息' ],
            [ 'name' => 'Manager.Index', 'label' => '文件管理' ],
            [ 'name' => 'Manager.Root', 'label' => '文件查询' ],
            [ 'name' => 'Manager.Create.Folder', 'label' => '创建文件夹' ],
            [ 'name' => 'Manager.Open.File', 'label' => '编辑文件' ],
            [ 'name' => 'Manager.Rename.File', 'label' => '重新命名' ],
            [ 'name' => 'Manager.Delete.File', 'label' => '删除文件' ],
            [ 'name' => 'Manager.File', 'label' => '上传文件' ],
            [ 'name' => 'Manager.Avatar', 'label' => '上传头像' ],
        ] );


    }
}
