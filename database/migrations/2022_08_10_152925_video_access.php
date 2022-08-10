<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VideoAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_access', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('video_id')->nullable()->references('id')->on('videos')->nullOnDelete();
            $table->bigInteger('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->bigInteger('admin_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->integer('status')->default(0);
            $table->text('message')->nullable();
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
        Schema::dropIfExists('video_access');
    }
}
