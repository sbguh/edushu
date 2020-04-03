<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNovelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novels', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('title');
          $table->string('sub_title')->nullable();
          $table->string('author')->nullable();
          $table->string('press')->nullable();
          $table->string('press_date')->nullable();
          $table->text('description');
          $table->string('image');
          $table->string('thumbnail')->nullable();
          $table->string('barcode');
          $table->string('audio')->nullable();
          $table->boolean('on_sale')->default(true);
          $table->unsignedInteger('stock')->default(0);
          $table->float('rating')->default(5);
          $table->unsignedInteger('sold_count')->default(0);
          $table->unsignedInteger('review_count')->default(0);
          $table->decimal('price', 10, 2)->nullable();
          $table->json('extras')->nullable();
          $table->json('features')->nullable();
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
        Schema::dropIfExists('novels');
    }
}
