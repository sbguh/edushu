<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('report_number');
            $table->string('title');
            $table->string('detail')->nullable();
            $table->text('description')->nullable();
            $table->text('date_time')->nullable();
            $table->unsignedBigInteger('classroom_id')->index();
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('delivery')->default(0);
            $table->boolean('public')->default(1);
            $table->json('extras')->nullable();

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
        Schema::dropIfExists('reports');
    }
}
