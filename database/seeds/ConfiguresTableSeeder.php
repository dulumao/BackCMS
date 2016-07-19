<?php

use Illuminate\Database\Seeder;

class ConfiguresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'configures' )->insert( [
            [
                'key'   => 'web_name',
                'value' => 'BackCMS',
                'name'  => '网站名称',
                'type'  => 1
            ], [
                'key'   => 'web_lang',
                'value' => 'zh-cn',
                'name'  => '默认语言',
                'type'  => 1
            ], [
                'key'   => 'web_logo',
                'value' => null,
                'name'  => '网站LOGO',
                'type'  => 1
            ]
        ] );
    }
}
