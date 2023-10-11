<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('comic_id');
            $table->unsignedBigInteger('chapter_id')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'comic_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('comic_id')->references('id')->on('comics');
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
        Schema::dropIfExists('libraries');
    }
}
