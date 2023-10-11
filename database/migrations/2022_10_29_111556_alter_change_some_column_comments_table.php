<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeSomeColumnCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('comments')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->renameColumn('messeges', 'messages');

                $table->unsignedBigInteger('rating_id');
                $table->unsignedBigInteger('like')->default(0)->after('messeges');
                $table->boolean('pin')->default(0)->after('like');
                $table->string('image')->nullable()->after('rating_id');

                $table->timestamp('updated_at');
                $table->longText('messeges')->change();
                $table->foreign('rating_id')->references('id')->on('ratings')->onDelete('cascade');

                $table->dropForeign('comments_chapter_id_foreign');
                $table->dropColumn('chapter_id');
                $table->dropColumn('deleted_at');
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
