<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\MovePendingBalanceToMain;
use App\Console\Commands\SendEventReminders;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('model:prune')->daily()->everyMinute();
        $schedule->command('app:move-pending-balance-to-main')->everyMinute()->withoutOverlapping();
        $schedule->command('location:update')->daily();
        $schedule->command('app:welcome-mail')->everyMinute();
        $schedule->command('app:delete-user-data')->everyMinute();
        $schedule->command('app:run-scheduled-notifications')->everyMinute();
        $schedule->command('app:update-recurring-events')->everyMinute();
        $schedule->command('app:notify-next-occurrence')->everyMinute();
        $schedule->command('app:send-next-occurrence-reminders')->everyMinute();
        $schedule->command('app:conclude-events')->everyMinute();
        $schedule->command('app:conclude-recurring-events')->everyMinute();
        $schedule->command('app:send-event-reminders')->everyMinute();
        $schedule->command('app:return-ticket-if-not-paid')->hourly();
        $schedule->command('app:send-event-purchase-reminder')->everyTenMinutes();
        $schedule->command('app:settle-event-payments-to-merchant-balance')->everyMinute();
        $schedule->command('queue:retry all')->everyMinute();
        $schedule->command('queue:work --stop-when-empty')->everyMinute();
        $schedule->command('app:process-n-g-n-withdrawals')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
