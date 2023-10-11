<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSetUniqueNumberComicIdColumnChaptersTable extends Migration
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
                $table->unique(['number', 'comic_id'])->change();
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
