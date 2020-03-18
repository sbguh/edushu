<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookAudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_audios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('book_id')->unique();
            $table->foreign('book_id')->references('id')->on('books');
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
        Schema::dropIfExists('book_audios');
    }
}
