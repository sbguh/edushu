<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVipCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('type_id')->default(1);;
            $table->unsignedBigInteger('phone_number')->unique();
            $table->string('real_name')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('gender')->nullable();
            $table->integer('deposit')->default(0);
            $table->integer('balance')->default(0);
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
        Schema::dropIfExists('vip_cards');
    }
}
