<?php

namespace App\Console;

use App\Mail\PaymentReminder;
use App\Models\ReservationPaymentDate;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $payment_dates = ReservationPaymentDate::where('date', date('Y-m-d', strtotime('+2 days', strtotime(date('Y-m-d')))))->get();
            foreach ($payment_dates as $payment_date){
                Mail::send(new PaymentReminder($payment_date));
            }
        })->dailyAt('10:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
