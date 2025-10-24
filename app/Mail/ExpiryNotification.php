<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $foodItems;

    public function __construct($foodItems)
    {
        $this->foodItems = $foodItems;
    }

    public function build()
    {
        return $this->subject('Food Expiry Notification')
                    ->view('emails.expiry_notification');
    }
}
