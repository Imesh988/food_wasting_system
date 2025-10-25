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
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'food:check-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check food expiry and send email to super admin';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $today = Carbon::today()->toDateString();

    // Only foods expiring today
    $todayExpiredFoods = Food::whereDate('expiry_date', $today)->get();

    if ($todayExpiredFoods->isNotEmpty()) {
        \Mail::to('imeshramanayaka988@gmail.com')
             ->send(new ExpiryNotification($todayExpiredFoods));

        $this->info('✅ Expire notification sent for ' . $todayExpiredFoods->count() . ' food items.');
        \Log::info('Expire notification sent for ' . $todayExpiredFoods->count() . ' food items.');
    } else {
        $this->info('🎉 No food expired today.');
        \Log::info('No food expired today.');
    }

    $this->info('⏱ Scheduler ran at ' . now());
    \Log::info('Scheduler ran at ' . now());
}

}
