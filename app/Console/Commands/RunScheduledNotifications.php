<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunScheduledNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-scheduled-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs all scheduled notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //fetch notifications
        $notifications = UserNotification::where('status','!=',1)->get();
        if ($notifications->count() > 0) {
            foreach ($notifications as $notification) {
                try {
                    $user = User::find($notification->user);

                    if (!$user) {
                        throw new \Exception("User not found for Notification ID: {$notification->id}");
                    }

                    try {
                        // Attempt to send push notification
                        sendPushNotification($user, $notification->title, $notification->content);
                    } catch (\Exception $pushError) {
                        // Log push notification failure but continue
                        Log::error("Error sending push notification for Notification ID {$notification->id}: " . $pushError->getMessage());
                    }

                    // Mark notification as sent
                    $notification->update(['status' => 1]);

                } catch (\Exception $e) {
                    // Log error and continue with the next notification
                    Log::error("Error sending notification ID {$notification->id}: " . $e->getMessage());
                }
            }
        }
    }
}
