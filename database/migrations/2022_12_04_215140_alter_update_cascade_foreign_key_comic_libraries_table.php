<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUpdateCascadeForeignKeyComicLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('libraries')) {
            Schema::table('libraries', function (Blueprint $table) {
                $table->dropForeign('libraries_comic_id_foreign');
                $table->foreign('comic_id')
                    ->references('id')
                    ->on('comics')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
