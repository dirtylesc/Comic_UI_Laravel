<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddLikePinColumnRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('ratings', 'like')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->unsignedBigInteger('like')->default(0)->after('messages');
            });
        }
        if (!Schema::hasColumn('ratings', 'pin')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->boolean('pin')->default(0)->after('like');
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
