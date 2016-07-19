<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call( AdminPermissionRolesTableSeeder::class );
        $this->call( AdminPermissionsTableSeeder::class );
        $this->call( AdminsTableSeeder::class );
        $this->call( ConfiguresTableSeeder::class );
        $this->call( TemplatesPermissionsTableSeeder::class );
    }
}
