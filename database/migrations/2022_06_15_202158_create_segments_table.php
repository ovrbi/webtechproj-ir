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
            $table->time('starttime');
            $table->time('endtime');
            $table->time('itemtime')->nullable();
            $table->integer('damagetaken');
            $table->integer('order');
            $table->foreignId('speedrun_id')->references('id')->on('speedruns')->onDelete('cascade');
            $table->time('boss_starttime');
            $table->time('boss_endtime');
            $table->integer('boss_damagetaken');
            $table->string('item',32);
            $table->foreign('item')->references('name')->on('items')->nullable();
            $table->string('place',32);
            $table->foreign('place')->references('name')->on('places');
            $table->string('boss',32);
            $table->foreign('boss')->references('name')->on('bosses');
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
