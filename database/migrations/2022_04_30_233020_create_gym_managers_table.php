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
        Schema::create('gym_managers', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->bigInteger('national_id')->unique();
            $table->unsignedBigInteger('gym_id');
            $table->string('avatar_image');
            $table->timestamps();
            $table->foreign('id')->references('id')->on('users');
            $table->foreign('gym_id')->references('id')->on('gyms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gym_managers');
    }
};
