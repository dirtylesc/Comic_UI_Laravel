<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDeleteAddSomeColumnComicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('comics', 'like')) {
            Schema::table('comics', function (Blueprint $table) {
                $table->dropColumn('like');
            });
        }
        if (Schema::hasColumn('comics', 'dislike')) {
            Schema::table('comics', function (Blueprint $table) {
                $table->dropColumn('dislike');
            });
        }
        if (!Schema::hasColumn('comics', 'star')) {
            Schema::table('comics', function (Blueprint $table) {
                $table->unsignedDecimal('star', 8, 1)->after('status')->default(0);
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
