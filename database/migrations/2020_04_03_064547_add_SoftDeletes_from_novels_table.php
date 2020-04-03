<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesFromNovelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('novels', function (Blueprint $table) {
            $table->softDeletes();
            $table->unsignedInteger('rent_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('novels', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
