<?php

use Illuminate\Database\Seeder;

class AdminPermissionRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'admin_permission_roles' )->insert( [
            'name' => '超级管理员'
        ] );
    }
}
