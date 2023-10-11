<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeCascadeComicIdComicCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('comic_categories')) {
            Schema::table('comic_categories', function (Blueprint $table) {
                $table->dropForeign('comic_categories_comic_id_foreign');
                $table->foreign('comic_id')->references('id')->on('comics')->onDelete('cascade');
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
