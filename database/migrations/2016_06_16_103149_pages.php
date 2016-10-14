<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'pages', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'title', 255 );
            $table->longText( 'body' );
            $table->integer( 'type' )->comment( '类型' );
            $table->integer( 'status' )->comment( '状态' );
            $table->integer( 'engine' )->comment( '解析引擎' );
            $table->integer( 'enabled' )->comment( '线上启用' );
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
        Schema::drop( 'pages' );
    }
}