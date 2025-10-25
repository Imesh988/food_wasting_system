<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ExpiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $foodItems; // Collection of expired foods

    /**
     * Create a new message instance.
     */
    public function __construct(Collection $foodItems)
    {
        $this->foodItems = $foodItems;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Food Expiry Notification')
                    ->view('emails.expiry_notification') 
                    ->with([
                        'foodItems' => $this->foodItems,
                    ]);
    }
}
