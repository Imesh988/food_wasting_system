<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ExpiryNotification extends Mailable
{
    use Queueable, SerializesModels;

   public $todayExpiredFoods;
public $next3DaysFoods;

public function __construct($todayExpiredFoods, $next3DaysFoods)
{
    $this->todayExpiredFoods = $todayExpiredFoods;
    $this->next3DaysFoods = $next3DaysFoods;
}

public function build()
{
    return $this->subject('Food Expiry Notification')
                ->view('emails.expiry_notification')
                ->with([
                    'todayExpiredFoods' => $this->todayExpiredFoods,
                    'next3DaysFoods'   => $this->next3DaysFoods,
                ]);
}

}
