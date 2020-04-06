<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('teacher')->nullable();
            $table->text('begain_time')->nullable();
            $table->text('start_time')->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->string('media_id')->nullable();
            $table->string('image_group')->nullable();
            $table->text('detail')->nullable();
            $table->text('description')->nullable();
            $table->json('extras')->nullable();
            $table->boolean('delivery')->default(0);
            $table->boolean('public')->default(1);
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
        Schema::dropIfExists('classrooms');
    }
}
