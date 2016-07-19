<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Templates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'templates', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'name', 255 );
            $table->text( 'code' );
            $table->integer( 'type' )->comment( '模版类型' );
            $table->integer( 'system' )->comment( '系统模版' );
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
        Schema::drop( 'templates' );
    }
}