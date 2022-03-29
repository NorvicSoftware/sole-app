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
        Schema::create('ratingables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ratingable_id');
            $table->string('ratingable_type');
            $table->unsignedBigInteger('rating_id')->nullable();
            $table->foreign('rating_id')->references('id')->on('ratings')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratingables');
    }
};
