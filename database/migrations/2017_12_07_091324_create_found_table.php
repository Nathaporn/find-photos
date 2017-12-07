<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('found', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('search_id')->unsigned();
          $table->string('csv_path');
          $table->timestamps();

          $table->foreign('search_id')
            ->references('id')->on('search')
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
        Schema::dropIfExists('found');
    }
}
