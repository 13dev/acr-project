<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayedSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('played_songs', function (Blueprint $table) {
            $table->id();
            $table->uuid('song_id');
            $table->integer('times');
            $table->timestamps();

            $table->foreign('song_id')
                ->references('id')
                ->on('songs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('played_songs');
    }
}
