<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->integer('userType')->default(1);
            $table->integer('status')->default(1);
            $table->integer('otp')->nullable();
            $table->integer('allowPasswordChange')->default(0);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('users')->insert(array('name' => 'subham saha','email' => 'subham.5ine@gmail.com','phone' => '7892156160','otp' => '7892','password' => '$2y$10$lbG32MTjcGqhG7ogF6d13OBGDuVimLeugJApy1oeCUB/LXNl2X5KK'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
