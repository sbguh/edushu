<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookKeywordPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_keyword', function (Blueprint $table) {
            $table->unsignedInteger('book_id')->unsigned()->index();
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->unsignedInteger('keyword_id')->unsigned()->index();
            $table->foreign('keyword_id')->references('id')->on('keywords')->onDelete('cascade');
            $table->primary(['book_id', 'keyword_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_keyword');
    }
}
