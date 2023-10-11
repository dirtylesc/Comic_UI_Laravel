<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('messeges');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('chapter_id');

            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();

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
        Schema::dropIfExists('comments');
    }
}
