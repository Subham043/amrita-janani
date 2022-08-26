<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Faqs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
            $table->bigInteger('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('faqs')->insert(array('question' => 'Why do you need my e-mail ID?','answer' => 'This is only to help the Admin to get in touch with you, where required w.r.t your account.','user_id' => 1));
        DB::table('faqs')->insert(array('question' => 'Why do I need to register to look at the content?','answer' => 'The process of registration is only to improve the user experience. Once registered, the user gets a dashboard where she/he can keeep track of the topic of interest.','user_id' => 1));
        DB::table('faqs')->insert(array('question' => "I'm new to the teachings of Guruji. Can I start practicing based on the content available on this website?",'answer' => 'The purpose of the repository is to make the teachings of Guruji accessible to all his disciples. It is in your best interest that you get in touch with Devipuram to undergo the necessary training instead of starting on your own. Contact details are provided in this website.','user_id' => 1));
        DB::table('faqs')->insert(array('question' => "I have some content which was taught by Guruji Amritananda. How do I share it on the website?",'answer' => "Users cannot directly upload any files. This is to make sure that the website doesn't get spammed with irrelevant content. Write to us and we will be happy to get in touch with you.",'user_id' => 1));
        DB::table('faqs')->insert(array('question' => "I have recently shared some content with your team, however I don't see it on the website. Why?",'answer' => "Rest assured that the content is being looked into and processed. Only the relevant content will be hosted as it is in the interest of all the users. Get in touch with us in case you have further queries!",'user_id' => 1));
        DB::table('faqs')->insert(array('question' => "Can I contribute some money towards Gurujis trust?",'answer' => "Contact Devipuram for the same.",'user_id' => 1));
        DB::table('faqs')->insert(array('question' => "Some features are not working as expected?",'answer' => "Please write to us through the contact page and the information will be passed on to the relevant team.",'user_id' => 1));
        DB::table('faqs')->insert(array('question' => "I have some feedback about this portal?",'answer' => "Please write us through the contact page and the information will be passed on to the relevant team.",'user_id' => 1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
}
