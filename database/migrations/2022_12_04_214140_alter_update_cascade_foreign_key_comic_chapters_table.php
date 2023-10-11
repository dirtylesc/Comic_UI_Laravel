<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUpdateCascadeForeignKeyComicChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('chapters')) {
            Schema::table('chapters', function (Blueprint $table) {
                $table->dropForeign('chapters_comic_id_foreign');
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
