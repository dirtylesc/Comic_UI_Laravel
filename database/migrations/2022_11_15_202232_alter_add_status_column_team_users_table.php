<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddStatusColumnTeamUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('team_users', 'status')) {
            Schema::table('team_users', function (Blueprint $table) {
                $table->smallInteger('status')->default('1')->after('user_id');
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
        if (Schema::hasColumn('team_users', 'status')) {
            Schema::dropColumns("team_users", 'status');
        }
    }
}
