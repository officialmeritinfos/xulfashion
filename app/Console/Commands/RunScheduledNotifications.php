<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Console\Command;

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
        if ($notifications->count()>0){
            foreach ($notifications as $notification) {
                $user = User::where('id',$notification->user)->first();
                if (!empty($user)){
                    sendPushNotification($user,$notification->title,$notification->content);
                    $notification->update(['status' => 1]);
                }
            }
        }
    }
}
