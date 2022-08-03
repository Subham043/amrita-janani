<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Images extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('uuid')->unique();
            $table->text('description')->nullable();
            $table->text('description_unformatted')->nullable();
            $table->text('tags')->nullable();
            $table->string('year')->nullable();
            $table->string('version')->nullable();
            $table->bigInteger('language_id')->nullable()->references('id')->on('languages')->nullOnDelete();
            $table->string('deity')->nullable();
            $table->bigInteger('views')->default(0);
            $table->bigInteger('favourites')->default(0);
            $table->text('image')->nullable();
            $table->text('topics')->nullable();
            $table->integer('status')->default(1);
            $table->integer('restricted')->default(0);
            $table->bigInteger('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('images');
    }
}
