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
        Schema::create('city_managers', function (Blueprint $table) {
            $table->unsignedBigInteger('city_manager_id')->unique();
            $table->bigInteger('national_id')->unique();
            $table->unsignedBigInteger('city_id')->unique();
            $table->string('avatar_image');
            $table->timestamps();
            $table->foreign('city_manager_id')->references('id')->on('users');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_managers');
    }
};
