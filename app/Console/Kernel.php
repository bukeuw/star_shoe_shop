<?php

namespace App\Console;

use App\CartItem;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            $cartItems = CartItem::all();
            
            foreach ($cartItems as $item) {
                $created = $item->created_at->addDays(3);
                $expired = Carbon::now();

                if($created->eq($expired)) {
                    $item->delete();
                }
            }
        })->daily();
    }
}
