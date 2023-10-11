<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddRatingIdComicIdColumnReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('reports', 'comic_id')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->unsignedBigInteger('comic_id')->nullable()->after('user_id');
                $table->foreign('comic_id')->references('id')->on('comics')->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('reports', 'rating_id')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->unsignedBigInteger('rating_id')->nullable()->after('comic_id');
                $table->foreign('rating_id')->references('id')->on('ratings')->onDelete('cascade');
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
