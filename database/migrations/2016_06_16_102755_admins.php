<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Admins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'admins', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'username', 50 )->unique();
            $table->string( 'phone', 20 );
            $table->string( 'email' )->unique();
            $table->string( 'password', 255 );
            $table->string( 'avatar', 255 );
            $table->string( 'nickname', 20 );
            $table->integer( 'admin_permission_role_id' );
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( 'admins' );
    }
}