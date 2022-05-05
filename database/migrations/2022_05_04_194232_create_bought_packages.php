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
        Schema::create('bought_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trainee_id');
            $table->unsignedBigInteger('training_package_id');
            $table->unsignedBigInteger('gym_id');
            $table->unsignedDouble('purchase_price');
            $table->timestamps();
            $table->foreign('trainee_id')->references('id')->on('users');
            $table->foreign('training_package_id')->references('id')->on('training_packages');
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
        Schema::dropIfExists('bought_packages');
    }
};
