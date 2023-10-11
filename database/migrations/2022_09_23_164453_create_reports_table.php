<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('messeges');
            $table->smallInteger('type');
            $table->smallInteger('status');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('chapter_id');
            $table->unsignedBigInteger('comment_id');

            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('comment_id')->references('id')->on('comments');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('chapter_id')->references('id')->on('chapters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
