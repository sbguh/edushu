<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('author')->nullable();
            $table->string('press')->nullable();
            $table->string('press_date')->nullable();
            $table->double('price')->nullable();
            $table->json('images')->nullable();
            $table->text('description')->nullable();
            $table->json('details')->nullable();
            $table->json('features')->nullable();
            $table->json('extras')->nullable();
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('last_chapter')->nullable();
            $table->integer('read_count')->default(0);
            $table->integer('word_count')->default(0);
            $table->integer('sort')->default(0);
            $table->integer('state')->default(1);
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
        Schema::dropIfExists('books');
    }
}
