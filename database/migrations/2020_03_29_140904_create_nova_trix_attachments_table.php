<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNovaTrixAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nova_trix_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attachable_type');
            $table->unsignedInteger('attachable_id');
            $table->string('attachment');
            $table->string('disk');
            $table->string('url')->index();
            $table->timestamps();

            $table->index(['attachable_type', 'attachable_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nova_trix_attachments');
    }
}
