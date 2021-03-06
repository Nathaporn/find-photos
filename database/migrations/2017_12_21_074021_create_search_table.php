<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->integer('target_id')->unsigned();
          $table->integer('url_id')->unsigned();
          $table->string('result')->default('not found');
          $table->string('feedback')->default('none');
          $table->timestamps();

          $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
          $table->foreign('target_id')
            ->references('id')->on('targets')
            ->onDelete('cascade');
          $table->foreign('url_id')
            ->references('id')->on('urls')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search');
    }
}
