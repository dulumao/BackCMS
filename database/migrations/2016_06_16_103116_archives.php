<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Archives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'archives', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'title', 255 );
            $table->string( 'keywords', 255 );
            $table->string( 'description', 255 );
            $table->text( 'body' );
            $table->integer( 'enabled' );
            $table->integer( 'archive_field_id' )->comment( '文章组件字段' );
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
        Schema::drop( 'archives' );
    }
}