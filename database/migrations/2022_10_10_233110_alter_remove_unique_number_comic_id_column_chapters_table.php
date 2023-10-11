<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRemoveUniqueNumberComicIdColumnChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('chapters', 'number') && Schema::hasColumn('chapters', 'comic_id')) {
            Schema::table('chapters', function (Blueprint $table) {
                $table->dropUnique('chapters_number_comic_id_unique');
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
