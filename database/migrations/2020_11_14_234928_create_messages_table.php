<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->integer('to_id')->index()->unsigned();
            $table->integer('from_id')->index()->unsigned();
            $table->string('content', 10000);
            $table->timestamps();

            $table->foreign('to_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('from_id')
                ->references('id')
                ->on('users')
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
        $table->dropForeign('user_id');
        Schema::dropIfExists('messages');
    }
}
