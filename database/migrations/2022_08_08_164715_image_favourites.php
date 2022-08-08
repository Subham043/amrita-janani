<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ImageFavourites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_favourites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('image_id')->nullable()->references('id')->on('images')->nullOnDelete();
            $table->bigInteger('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_favourites');
    }
}
