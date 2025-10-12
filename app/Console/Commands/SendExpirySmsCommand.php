<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Food;
use App\Services\TextLkService;
use Carbon\Carbon;

class SendExpirySmsCommand extends Command
{
    protected $signature = 'sms:send-expiry {days=2 : days before expiry to notify} {--test : do not actually call API}';
    protected $description = 'Send SMS alerts for foods expiring in N days';

    protected $textlk;

    public function __construct(TextLkService $textlk)
    {
        parent::__construct();
        $this->textlk = $textlk;
    }

    public function handle()
    {
        $days = (int)$this->argument('days');
        $targetDate = Carbon::today()->addDays($days)->toDateString();

        $this->info("Looking for foods expiring on: {$targetDate}");

        $items = Food::whereDate('expiry_date', $targetDate)
                     ->whereNotNull('owner_phone')
                     ->get();

        $this->info("Found {$items->count()} items.");

        foreach ($items as $item) {
            $phone = $item->owner_phone;
            // normalize phone: ensure starts with 94 (Sri Lanka)
            if (preg_match('/^0/', $phone)) {
                $phone = '94' . ltrim($phone, '0');
            } elseif (!preg_match('/^94/', $phone)) {
                // assume already correct or log and skip
            }

            $message = "Reminder: '{$item->name}' will expire on {$item->expiry_date->format('Y-m-d')}. Qty: {$item->quantity}. Please use or discard.";

            $this->info("Sending to {$phone}: {$message}");

            if ($this->option('test')) {
                $this->info("TEST MODE: not calling Text.lk");
                continue;
            }

            $resp = $this->textlk->sendSms($phone, $message);

            $this->info("Response: " . json_encode($resp['body'] ?? $resp));
            // optionally store response id/status to DB for auditing
        }

        return 0;
    }
}
