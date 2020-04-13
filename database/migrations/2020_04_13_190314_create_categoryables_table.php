<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoryables', function (Blueprint $table) {
          $table->unsignedInteger('category_id')->index();
          $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
          $table->unsignedBigInteger('categoryable_id');
          $table->string('categoryable_type');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoryables');
    }
}
