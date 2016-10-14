<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArchiveFieldsAddCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'archive_fields', function ( Blueprint $table ) {
            $table->string( 'image' ,255)->comment( '缩略图' );
            $table->string( 'description' ,255)->comment( '长描述' );
            $table->string( 'short_description' ,255)->comment( '短描述' );
            $table->string( 'forward' ,255)->comment( '跳转地址' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'archive_fields', function ( Blueprint $table ) {
            $table->dropColumn( 'image' );
            $table->dropColumn( 'description' );
            $table->dropColumn( 'short_description' );
            $table->dropColumn( 'forward' );
        } );
    }
}
