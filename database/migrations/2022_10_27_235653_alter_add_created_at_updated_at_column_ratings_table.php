<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddCreatedAtUpdatedAtColumnRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('ratings', 'created_at')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->timestamp('created_at')->nullable()->after('image');
            });
        }
        if (!Schema::hasColumn('ratings', 'updated_at')) {
            Schema::table('ratings', function (Blueprint $table) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
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
