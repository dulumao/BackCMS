<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'admin_permissions', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'name', 255 );
            $table->string( 'label', 255 );
            $table->string( 'description', 255 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( 'admin_permissions' );
    }
}
