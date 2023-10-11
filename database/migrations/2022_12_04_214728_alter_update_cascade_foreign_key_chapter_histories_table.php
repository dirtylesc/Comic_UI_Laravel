<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUpdateCascadeForeignKeyChapterHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('histories')) {
            Schema::table('histories', function (Blueprint $table) {
                $table->dropForeign('histories_chapter_id_foreign');
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
