<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('page_name')->unique();
            $table->string('url')->unique();
            $table->integer('status')->default(1);
            $table->integer('restricted')->default(0);
            $table->bigInteger('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('pages')->insert(array('title' => 'Home','page_name' => 'home','url' => 'home','user_id' => 1));
        DB::table('pages')->insert(array('title' => 'About Us','page_name' => 'about','url' => 'about','user_id' => 1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
