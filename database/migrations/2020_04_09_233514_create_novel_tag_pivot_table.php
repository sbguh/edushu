<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNovelTagPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novel_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('novel_id')->index();
            $table->foreign('novel_id')->references('id')->on('novels')->onDelete('cascade');
            $table->unsignedInteger('tag_id')->index();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->primary(['novel_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('novel_tag');
    }
}
