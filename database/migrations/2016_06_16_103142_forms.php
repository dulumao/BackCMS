<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Forms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'forms', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->longText( 'body' );
            $table->string( 'plugin' );
            $table->string( 'token', 255 );
            $table->integer( 'foreign_key' )->comment('用于关联各种外键');
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
        Schema::drop( 'forms' );
    }
}