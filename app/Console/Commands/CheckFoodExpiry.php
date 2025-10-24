<?php

namespace App\Console\Commands;

use App\Mail\ExpiryNotification;
use App\Models\Food;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
    protected $description = 'Check food expiry and send email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $today = Carbon::today()->toDateString();
        $expiredFood = Food::where('expiry_date','<=', $today)->get();

        if($expiredFood->isNotEmpty()){
            Mail::to('imeshramanayaka988@gmail.com')->send(new ExpiryNotification($expiredFood));
            $this->info('Expire notification send !' . $expiredFood->count() . 'food item !!');
        }else{
            $this->info('not food today expire !!');
        }
            $this->info('⏱ Scheduler ran at' . now());

    }
}
