<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'admins' )->insert( [
            'username'                 => 'admin',
            'phone'                    => '13000000000',
            'email'                    => 'admin@me.com',
            'password'                 => \Hash::make( 'admin' ),
            'avatar'                   => asset( 'statics/img/backcms.png' ),
            'nickname'                 => '管理员',
            'admin_permission_role_id' => '1'
        ] );
    }
}
