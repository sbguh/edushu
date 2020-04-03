<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInformationsFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('description');
            $table->string('wechat_description');
            $table->unsignedBigInteger('card_id')->default(1);;
            $table->unsignedBigInteger('phone_number')->unique()->nullable();
            $table->string('real_name')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('gender')->nullable();
            $table->integer('deposit')->default(0);
            $table->integer('balance')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_description');
            $table->dropColumn('wechat_description');
            $table->dropColumn('type_id');
            $table->dropColumn('real_name');
            $table->dropColumn('birthday');
            $table->dropColumn('gender');
            $table->dropColumn('deposit');
            $table->dropColumn('balance');
        });
    }
}
