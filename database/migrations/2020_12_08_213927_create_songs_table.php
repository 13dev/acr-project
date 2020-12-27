<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('album_id');
            $table->string('title');
            $table->integer('disc');
            $table->bigInteger('length')->unsigned();
            $table->integer('bitrate')->nullable();
            $table->boolean('explicit')->default(false);
            $table->boolean('compilation')->default(false);
            $table->text('path');
            $table->integer('mtime');
            $table->timestamps();

            $table->foreign('album_id')
                ->references('id')
                ->on('albums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
