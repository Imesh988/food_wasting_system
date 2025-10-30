<?php

namespace App\Console\Commands;

use App\Mail\ExpiryNotification;
use App\Models\Food;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckFoodExpiry extends Command
{
    protected $signature = 'food:check-expiry';
    protected $description = 'Check food expiry and send email to super admin';

    public function handle()
    {
        $today = Carbon::today();
        $threeDaysLater = $today->copy()->addDays(3);

        // Foods expiring today
        $todayExpiredFoods = Food::whereDate('expiry_date', $today)->get();

        // Foods expiring in next 3 days (excluding today)
        $next3DaysFoods = Food::whereDate('expiry_date', '>', $today)
                               ->whereDate('expiry_date', '<=', $threeDaysLater)
                               ->get();

        if ($todayExpiredFoods->isNotEmpty() || $next3DaysFoods->isNotEmpty()) {
            Mail::to('imeshramanayaka988@gmail.com')
                ->send(new ExpiryNotification($todayExpiredFoods, $next3DaysFoods));

            $this->info('✅ Expire notification sent: '
                . $todayExpiredFoods->count() . ' today, '
                . $next3DaysFoods->count() . ' in next 3 days.');
            Log::info('Expire notification sent: '
                . $todayExpiredFoods->count() . ' today, '
                . $next3DaysFoods->count() . ' in next 3 days.');
        } else {
            $this->info('🎉 No food expiring today or in next 3 days.');
            Log::info('No food expiring today or in next 3 days.');
        }

        $this->info('⏱ Scheduler ran at ' . now());
        Log::info('Scheduler ran at ' . now());
    }
}
