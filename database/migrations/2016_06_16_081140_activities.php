<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Activities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'activities', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'guard', 20 );
            $table->string( 'content', 255 );
            $table->integer( 'admin_id' );
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
        Schema::drop( 'activities' );
    }
}
