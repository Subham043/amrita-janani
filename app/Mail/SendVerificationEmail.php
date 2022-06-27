<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $otp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $otp)
    {
        $this->name = $name;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Amrita Janani - Verification')->view('emails.verify_user')->with([
            'name' => $this->name,
            'otp' => $this->otp,
        ]);
    }
}
