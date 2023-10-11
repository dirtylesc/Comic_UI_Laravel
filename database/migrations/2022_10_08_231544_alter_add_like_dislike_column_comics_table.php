<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddLikeDislikeColumnComicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('comics', 'like')) {
            Schema::table('comics', function (Blueprint $table) {
                $table->unsignedInteger('like')->default(0)->after('status');
            });
        }

        if (!Schema::hasColumn('comics', 'dislike')) {
            Schema::table('comics', function (Blueprint $table) {
                $table->unsignedInteger('dislike')->default(0)->after('like');
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
