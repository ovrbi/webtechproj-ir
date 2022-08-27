<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('segments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('starttime');
            $table->integer('endtime');
            $table->integer('itemtime')->nullable();
            $table->integer('damagetaken');
            $table->integer('order');
            $table->foreignId('speedrun_id')->references('id')->on('speedruns')->onDelete('cascade');
            $table->integer('boss_starttime');
            $table->integer('boss_endtime');
            $table->integer('boss_damagetaken');
            $table->foreignId('item')->nullable()->references('id')->on('items');
            $table->foreignId('place')->references('id')->on('places');
            $table->foreignId('boss')->references('id')->on('bosses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('segments');
    }
};
