<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Configures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'configures', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'key', 255 );
            $table->string( 'value', 255 );
            $table->string( 'name', 255 );
            $table->integer( 'type' )->comment( '变量类型 系统变量 自定义变量' );
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
        Schema::drop( 'configures' );
    }
}