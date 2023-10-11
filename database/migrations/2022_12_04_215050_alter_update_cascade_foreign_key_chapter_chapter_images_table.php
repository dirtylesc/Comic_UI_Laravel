<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUpdateCascadeForeignKeyChapterChapterImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('chapter_images')) {
            Schema::table('chapter_images', function (Blueprint $table) {
                $table->dropForeign('chapter_images_chapter_id_foreign');
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
