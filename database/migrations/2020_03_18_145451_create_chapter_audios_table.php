<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChapterAudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_audios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('chapter_id')->unique();
            $table->foreign('chapter_id')->references('id')->on('chapters');
            $table->binary('audio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chapter_audios');
    }
}
