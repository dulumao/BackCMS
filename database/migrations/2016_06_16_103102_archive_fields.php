<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArchiveFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'archive_fields', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->text( 'field' );
            $table->string( 'name', 255 );
            $table->integer( 'list_template' )->comment( '列表模版' );
            $table->integer( 'show_template' )->comment( '内容模版' );
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
        Schema::drop( 'archive_fields' );
    }
}