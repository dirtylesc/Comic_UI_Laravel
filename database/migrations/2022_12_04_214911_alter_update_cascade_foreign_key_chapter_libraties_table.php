<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUpdateCascadeForeignKeyChapterLibratiesTable extends Migration
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
                $table->dropForeign('libraries_chapter_id_foreign');
                $table->foreign('chapter_id')
                    ->references('id')
                    ->on('chapters')
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
