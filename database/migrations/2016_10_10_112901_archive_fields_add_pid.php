<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArchiveFieldsAddPid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'archive_fields', function ( Blueprint $table ) {
            $table->integer( 'pid' )->after( 'id' )->default( 0 )->comment( '父分类id' );
            $table->integer( 'deepth' )->after( 'pid' )->default( 0 )->comment( '层级深度' );
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
            $table->dropColumn( 'pid' );
            $table->dropColumn( 'deepth' );
        } );
    }
}
