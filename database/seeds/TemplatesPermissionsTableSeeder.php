<?php

use Illuminate\Database\Seeder;

class TemplatesPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'templates' )->insert( [
            [ 'name' => '首页', 'code' => '@welcome', 'type' => 2, 'system' => 1 ],
            [ 'name' => '文章列表', 'code' => 'BackCMS List', 'type' => 2, 'system' => 1 ],
            [ 'name' => '文章内容', 'code' => 'BackCMS Show', 'type' => 2, 'system' => 1 ]
        ] );
    }
}
